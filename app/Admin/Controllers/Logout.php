<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 处理登录请求。
 *
 * @author fy
 *
 * @version $Revision: 1.0 $
 */
class Logout extends Controller
{
    /**
     * 处理请求。
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect()->route('login');
    }
}
