<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * 管理员服务类
 */
class UserService extends BaseService
{
    /**
     * @var array 管理员状态
     */
    const STATUS = [
        'normal' => '正常',
        'freeze' => '冻结',
        'deleted' => '删除',
    ];

    /**
     * @var array 性别数据
     */
    const GENDER = [
        'male' => '男性',
        'female' => '女性',
        'secret' => '未知',
    ];

    /**
     * 管理员列表
     *
     * @param array $condition
     * @param integer $page
     * @param integer $limit
     * @return void
     */
    public static function paginate($params=[], $page=1, $limit=20)
    {
        return User::latest('id')
                    ->when($params['nick_name'] ?? '', function ($query, $nick_name) {
                        $query->where('nick_name', 'like', '%'.$nick_name.'%');
                    })->when($params['mobile'] ?? '', function ($query, $mobile) {
                        $query->where('mobile', 'like', '%'.$mobile.'%');
                    })->when($params['real_name'] ?? '', function ($query, $real_name) {
                        $query->where('real_name', 'like', '%'.$real_name.'%');
                    })->when($params['card_no'] ?? '', function ($query, $card_no) {
                        $query->where('card_no', 'like', '%'.$card_no.'%');
                    })->when($params['gender'] ?? '', function ($query, $gender) {
                        $query->where('gender', $gender);
                    })->when($params['invite_code'] ?? '', function ($query, $invite_code) {
                        $query->where('invite_code', '=', $invite_code);
                    })->when($params['status'] ?? '', function ($query, $status) {
                        $query->where('status', '=', $status);
                    })->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * 管理员列表
     *
     * @param array $condition
     * @param integer $page
     * @param integer $limit
     * @return void
     */
    public static function list($params=[])
    {
        return User::latest('id')
                    ->when($params['nick_name'] ?? '', function ($query, $nick_name) {
                        $query->where('nick_name', 'like', '%'.$nick_name.'%');
                    })->when($params['mobile'] ?? '', function ($query, $mobile) {
                        $query->where('mobile', 'like', '%'.$mobile.'%');
                    })->when($params['real_name'] ?? '', function ($query, $real_name) {
                        $query->where('real_name', 'like', '%'.$real_name.'%');
                    })->when($params['card_no'] ?? '', function ($query, $card_no) {
                        $query->where('card_no', 'like', '%'.$card_no.'%');
                    })->when($params['gender'] ?? '', function ($query, $gender) {
                        $query->where('gender', $gender);
                    })->when($params['invite_code'] ?? '', function ($query, $invite_code) {
                        $query->where('invite_code', '=', $invite_code);
                    })->when($params['status'] ?? '', function ($query, $status) {
                        $query->where('status', '=', $status);
                    })->get()
                    ->toArray();
    }

    /**
     * 更改用户状态
     *
     * @param User $user
     * @return void
     */
    public static function changeStatus(User $user)
    {
        $statusData = self::STATUS;
        if ($user->status == $statusData['normal']) {
            $user->status = 'freeze';
        } else {
            $user->status = 'normal';
        }

        $user->save();

        return self::success();
    }

    /**
     * 获取用户信息
     *
     * @param [type] $data
     * @return void
     */
    public static function info($data=[])
    {
        $id = $data['id'] ?? 0;

        $user = User::with('house')
        ->when($data['unionid'] ?? '', function ($query, $unionid) {
            $query->where('unionid', '=', $unionid);
        })->when($data['mobile'] ?? '', function ($query, $mobile) {
            $query->where('mobile', '=', $mobile);
        })->when($data['nick_name'] ?? '', function ($query, $nick_name) {
            $query->where('nick_name', 'like', '%'.$nick_name.'%');
        })->when($data['real_name'] ?? '', function ($query, $real_name) {
            $query->where('real_name', '=', $real_name);
        })->when($data['card_no'] ?? '', function ($query, $card_no) {
            $query->where('card_no', '=', $card_no);
        })->when(isset($data['id']), function ($query) use ($id) {
            $query->where('id', '=', $id);
        })->first();

        if (empty($user)) {
            return self::error('获取用户信息失败');
        }

        // 获取当前小区名称
        // $communityName = ConfigService::get('system', 'community_name', '');

        // $houseData = $user->houses;
        // if ($houseData->isEmpty()) {
        //     $house = [];
        // } else {
        //     $house = $houseData[0];
        // }
        // $house['community_name'] = $communityName;
        // $user['house'] = $house;
        // unset($user['houses']);
        // $user->house->community_name = $communityName;

        return self::success($user);
    }
}
