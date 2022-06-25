<?php

namespace App\Admin\Controllers;

use App\Admin\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

/**
 * 处理登录请求。
 *
 * @author fy
 *
 * @version $Revision: 1.0 $
 */
class Login extends Controller
{
    /**
     * 处理请求。
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        if (Auth::attempt($request->only([
            'mobile', 'password'
        ]), $request->input('remember', false))) {
            return ['auth' => true];
        } else {
            return ['auth' => false];
        }
    }
}
