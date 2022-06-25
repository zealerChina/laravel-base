<?php

namespace App\Services;

use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

/**
 * 管理员服务类
 */
class AdminUserService extends BaseService
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
     * 管理员列表
     *
     * @param array $condition
     * @param integer $page
     * @param integer $limit
     * @return void
     */
    public static function paginate($params=[], $page=1, $limit=20)
    {
        return AdminUser::latest('id')
                    ->when($params['name'] ?? '', function ($query, $name) {
                        $query->where('name', 'like', '%'.$name.'%');
                    })->when($params['mobile'] ?? '', function ($query, $mobile) {
                        $query->where('mobile', 'like', '%'.$mobile.'%');
                    })->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * 新增管理员
     *
     * @param array $data
     * @return void
     */
    public static function add($data=[])
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        // 如果没上传头像, 则不需要添加头像
        if (is_null($data['avatar'])) {
            unset($data['avatar']);
        }

        AdminUser::create($data);

        return self::success();
    }

    /**
     * 更新
     *
     * @param AdminUser $user
     * @param array $data
     * @return void
     */
    public static function update($user, $data=[])
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        // 如果没上传头像, 则不需要更新头像
        if (is_null($data['avatar'])) {
            unset($data['avatar']);
        }

        $user->update($data);

        return self::success();
    }

    /**
     * Undocumented function
     *
     * @param [type] $user
     * @return void
     */
    public static function destroy($user)
    {
        // 不能删除自己和ID为1管理员
        $adminId = auth()->id();

        if ($user->id == 1 || $adminId == $user->id) {
            return self::error('无法删除起始管理员和自己');
        }

        $user->delete();

        return self::success();
    }

    /**
     * 更改用户状态
     *
     * @param User $user
     * @return void
     */
    public static function changeStatus(AdminUser $user)
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
}
