<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Resources\UserCollection;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * 用户控制器
 * 
 * @author fy
 */
class UserController extends Controller
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

        $users = UserService::paginate($params, $page, $limit);

        return new UserCollection($users);
    }

    /**
     * 编辑管理员
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function show(Request $request, User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * 更改用户状态
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function changeStatus(Request $request, User $user)
    {
        return UserService::changeStatus($user);
    }

    /**
     * 获取用户信息
     *
     * @param Request $request
     * @return void
     */
    public function info(Request $request)
    {
        $data = $request->all();

        return UserService::info($data);
    }
}
