<?php

namespace App\Services;

use App\Models\House;
use App\Models\SmsRecord;
use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;

/**
 * 认证控制器
 */
class AuthService extends BaseService
{
    /**
     * 获取微信小程序相关配置
     *
     * @return void
     */
    public static function getWechatConfig()
    {
        $config = ConfigService::get('wechat', '', []);

        return [
            'app_id' => $config['app_id'],
            'secret' => $config['app_secret']
        ];
    }

    /**
     * 获取微信小程序对象
     *
     * @return void
     */
    public static function getWechatApp()
    {
        $config = self::getWechatConfig();

        return Factory::miniProgram($config);
    }

    /**
     * 微信登录
     *
     * @param string $code
     * @return array
     */
    public static function wxlogin($code = '')
    {
        $app = self::getWechatApp();
        $data = $app->auth->session($code);

        $openid = $data['openid'] ?? '';

        if (empty($openid)) {
            return self::error('未获取到用户OPENID');
        }
        common_log($data);

        $user = User::where('openid', $openid)
                    ->first();

        // 如果用户未注册, 则返回openid走注册接口
        if (empty($user)) {
            return self::error('用户尚未注册, 请走注册接口', -10, [
                'openid' => $data['openid'] ?? '',
                'unionid' => $data['unionid'] ?? '',
                'session' => $data['session_key'] ?? ''
            ]);
        }
        $user = $user->toArray();

        common_log('登录成功, 用户ID为: '.$user['id']);
        common_log($user);

        return self::success([
            'token' => $user['token'],
            'info' => $user,
        ]);
    }

    /**
     * 微信注册
     *
     * @param array $data
     * @return void
     */
    public static function wxregister($data=[])
    {
        // 上线开启
        $validateResult = self::validateHouseData($data);
        if ($validateResult['code'] != 0) {
            return $validateResult;
        }
        common_log('注册传输数据');
        common_log($data);

        $session = $data['session'] ?? '';
        if (empty($session)) {
            common_log('获取session失败');

            return self::error('获取session失败');
        }

        // 判断短信验证码是否正确(调试阶段注释)
        $mobile = $data['mobile'] ?? '';
        $code = $data['mobile_code'] ?? '';
        $sms = SmsRecord::where([
            'type' => 'register',
            'mobile' => $mobile
        ])->orderBy('id', 'desc')->first();
        if (empty($sms)) {
            return self::error('尚未发送短信');
        }
        if ($sms->code != $code) {
            return self::error('验证码认证失败, 请重新填写');
        }

        $iv = $data['iv'] ?? '';
        $encrypt = $data['encrypt'];
        $app = self::getWechatApp();
        $encryptData = $app->encryptor->decryptData($session, $iv, $encrypt);
        common_log('注册解密数据');
        common_log($encryptData);
        // 获取unionID
        $unionid = '';
        if (!empty($data['unionid'])) {
            $unionid = $data['unionid'];
        } else if (!empty($encryptData['unionId'])) {
            $unionid = $encryptData['unionId'];
        }
        // 获取openid
        $openid = '';
        if (!empty($data['openid'])) {
            $openid = $data['openid'];
        } else if (!empty($encryptData['openId'])) {
            $openid = $encryptData['openId'];
        }

        // 判断该unionID对应的用户是否存在
        if (!empty(User::where('unionid', $unionid)->first())) {
            $user = User::where('unionid', $unionid)
                    ->first()
                    ->toArray();

            return self::success([
                'token' => $user['token'],
                'info' => $user
            ]);
        }

        $inviteCode = self::getInviteCode();
        $gender = 'secret';
        if ($data['gender'] == 1) {
            $gender = 'male';
        } else if ($data['gender'] == 2) {
            $gender = 'female';
        }
        $token = self::getToken($unionid);
        $insertData = [
            'unionid' => $unionid,
            'openid' => $openid,
            'nick_name' => $data['nickName'] ?: '',
            'avatar' => $data['avatarUrl'] ?: '',
            'province' => $data['province'] ?: '',
            'city' => $data['city'] ?: '',
            'mobile' => $data['mobile'] ?: '',
            'gender' => $gender,
            'invite_code' => $inviteCode,
            'token' => $token
        ];

        $user = User::create($insertData)->toArray();

        // 写入用户房间号
        House::where('id', $data['house_id'] ?? 0)
                ->update([
                    'user_id' => $user['id']
                ]);

        return self::success([
            'token' => $token,
            'info' => $user
        ]);
    }

    /**
     * 验证房间数据
     *
     * @param array $data
     * @return void
     */
    public static function validateHouseData($data = [])
    {
        // 判断当前用户的信息是否存在
        $houseId = $data['house_id'] ?? 0;
        $realName = $data['real_name'] ?? '';
        $cardNo = $data['card_no'] ?? '';
        $mobile = $data['mobile'] ?? '';
        $house = House::find($houseId);
        // 判断房间信息是否存在
        if (empty($house)) {
            return self::error('房间信息错误, 请重新选择');
        }
        // 判断真实姓名是否相同
        if ($realName != $house->real_name) {
            return self::error('姓名与房间对应户主姓名不对应');
        }
        // 判断身份证号是否相同
        if ($cardNo != $house->card_no) {
            return self::error('身份证号与房间对应户主身份证号不对应');
        }
        // 判断手机号是否相同
        if ($mobile != $house->mobile) {
            return self::error('手机号与房间对应户主手机号不对应');
        }

        return self::success();
    }

    /**
     * 绑定手机号
     *
     * @param array $data
     * @return void
     */
    public static function mobile($data)
    {
        $app = self::getWechatApp();
        $mobileData = $app->encryptor->decryptData($data['session'], $data['iv'], $data['encrypt']);
        $mobile = $mobileData['phoneNumber'] ?: 
                    ($mobileData['purePhoneNumber'] ?: 0);
        $unionid = $data['unionid'] ?? '';

        User::where('unionid', $unionid)
                ->update([
                    'mobile' => $mobile
                ]);

        return self::success();
    }

    /**
     * 获取六位随机大写字母
     *
     * @return void
     */
    private static function getInviteCode($num = 6)
    {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $len = mb_strlen($str);

        $result = '';
        for ($i=0; $i<$num; $i++) {
            $result .= $str[mt_rand(0, $len-1)];
        }

        return $result;
    }

    /**
     * 获取六位随机大写字母
     *
     * @return void
     */
    private static function getToken($salt='')
    {
        return md5(time() . $salt);
    }
}
