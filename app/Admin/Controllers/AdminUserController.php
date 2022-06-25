<?php

namespace App\Admin\Controllers;

use App\Admin\Requests\CreateAdminUserRequest;
use App\Admin\Requests\UpdateAdminUserRequest;
use App\Models\AdminUser;
use App\Resources\AdminUserCollection;
use App\Services\AdminUserService;
use App\Services\ConfigService;
use Illuminate\Http\Request;

/**
 * 管理员控制器
 * 
 * @author fy
 */
class AdminUserController extends Controller
{
    /**
     * 系统配置页面
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $page = $request->page;
        $limit = $request->limit;

        $params = $request->except([
            'page', 'limit'
        ]);

        $users = AdminUserService::paginate($params, $page, $limit);

        return new AdminUserCollection($users);
    }

    /**
     * 新增管理员保存方法
     *
     * @param Request $request
     * @return void
     */
    public function store(CreateAdminUserRequest $request)
    {
        $data = $request->only([
            'name',
            'mobile',
            'password',
            'status',
            'avatar'
        ]);

        $result = AdminUserService::add($data);

        return $result;
    }

    /**
     * 编辑管理员
     *
     * @param UpdateAdminUserRequest $request
     * @param AdminUser $user
     * @return void
     */
    public function edit(Request $request, AdminUser $user)
    {
        return view('admin_user.edit', compact('user'));
    }

    /**
     * 编辑提交
     *
     * @param UpdateAdminUserRequest $request
     * @param AdminUser $user
     * @return void
     */
    public function update(UpdateAdminUserRequest $request, AdminUser $user)
    {
        $data = $request->only([
            'name',
            'mobile',
            'password',
            'status',
            'avatar'
        ]);

        return AdminUserService::update($user, $data);
    }

    /**
     * 删除管理员
     *
     * @param AdminUser $user
     * @return void
     */
    public function destroy(AdminUser $user)
    {
        return AdminUserService::destroy($user);
    }

    /**
     * 更改用户状态
     *
     * @param Request $request
     * @param AdminUser $user
     * @return void
     */
    public function changeStatus(Request $request, AdminUser $user)
    {
        return AdminUserService::changeStatus($user);
    }
}
