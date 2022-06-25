<?php

namespace App\Admin\Controllers;

use App\Services\HomeService;

/**
 * 主页控制器
 * 
 * @author fy
 */
class HomeController extends Controller
{
    /**
     * 首页
     *
     * @return void
     */
    public function index()
    {
        $statistic = HomeService::statisticData();

        return view('home.index', compact('statistic'));
    }
}
