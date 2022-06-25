<?php

namespace App\Admin\Controllers;

use App\Services\CommonService;
use Illuminate\Http\Request;

/**
 * 公共控制器
 */
class CommonController extends Controller
{
    /**
     * 上传文件
     *
     * @param Request $request
     * @return void
     */
    public function upload(Request $request)
    {
        $path = $request->input('path', 'images');
        $file = $request->file('file');

        return CommonService::upload($file, $path);
    }

    /**
     * 上传文件
     *
     * @param Request $request
     * @return void
     */
    public function layEditUpload(Request $request)
    {
        $path = $request->input('path', 'images');
        $file = $request->file('file');


        return CommonService::layEditUpload($file, $path);
    }
}
