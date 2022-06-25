<?php

namespace App\Admin\Controllers;

use App\Imports\HouseImport;
use Excel;
use App\Services\AuthService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * 测试控制器
 */
class TestController extends Controller
{
    public function index(Request $request)
    {
        phpinfo();
    }
}
