<?php

namespace App\Services;

use App\Models\SmsRecord;
use Exception;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Strategies\OrderStrategy;

/**
 * 短信服务类
 */
class SmsService extends BaseService
{
    /**
     * 发送状态
     */
    const STATUS = [
        'unsend' => '待发送',
        'success' => '发送成功',
        'fail' => '发送失败',
    ];

    const TYPE = [
        'register' => '注册'
    ];

    /**
     * 支付列表
     *
     * @param array $condition
     * @param integer $page
     * @param integer $limit
     * @return void
     */
    public static function paginate($params=[], $page=1, $limit=20, $isApi=0)
    {
        $result = SmsRecord::orderBy('id', 'desc')
                ->when($params['mobile'] ?? '', function ($query, $mobile) {
                    $query->where('mobile', $mobile);
                })->when($params['type'] ?? '', function ($query, $type) {
                    $query->where('type', $type);
                })->when($params['status'] ?? '', function ($query, $status) {
                    $query->where('status', $status);
                })->paginate($limit, ['*'], 'page', $page);

        return $result;
    }

    /**
     * 发送短信
     *
     * @param string $mobile
     * @param array $params
     * @return array
     */
    public static function send($mobile, $params=[])
    {
        $type = $params['type'] ?? 'register';
        // 五分钟内只能发一次验证码
        $sms = SmsRecord::where([
            'mobile' => $mobile,
            'type' => $type,
            'status' => 'success'
        ])->orderBy('id', 'desc')
        ->first();
        if (!empty($sms)) {
            $codeTime = strtotime($sms->created_at);
            if (time() - $codeTime < 10) {
                return self::error('短信发送过于频繁, 请稍后再试');
            }
        }


        $code = mt_rand(100000, 999999);
        // 写入数据库数据
        $data = [
            'mobile' => $mobile,
            'type' => $type,
            'status' => 'unsend',
            'content' => ($params['content'] ?? '') . $code,
            'code' => $code
        ];

        $sms = SmsRecord::create($data);

        $config = ConfigService::get('sms');
			
        $smsConfig = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,
            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => OrderStrategy::class,
                // 默认可用的发送网关
                'gateways' => [ 'aliyun' ],
            ],
            // 可用的网关配置
            'gateways' => [
                "aliyun" => [
                    'access_key_id' => $config["access_key_id"] ?? '',
                    'access_key_secret' => $config["access_key_secret"] ?? '',
                    'sign_name' => $config["smssign"] ?? '',
                ]
            ],
        ];
        
        try {
            $templateId = $config['register_template_id'] ?? '';
            $client = new EasySms($smsConfig);
            $client->send($mobile, [
                'template' => $templateId,
                'data' => [
                    'code' => $code
                ]
            ]);

            $sms->status = 'success';
            $sms->save();

            // return self::success('短信发送成功');
            // 调试阶段, 直接返回验证码
            return self::success(['mobile_code' => $code]);
        } catch (Exception $e) {
            common_log('发送短信失败', $e);
            common_log('短信数据为: '.json_encode($data).', 手机号为:'.$mobile);
            common_log('报错信息: '.$e->getException('aliyun')->getMessage());

            $sms->status = 'fail';
            $sms->save();

            return self::error('短信发送失败', -1, ['mobile_code' => $code]);
        }
    }
}
