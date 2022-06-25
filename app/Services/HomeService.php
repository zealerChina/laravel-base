<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Post;
use App\Models\PostReply;

/**
 * 主页服务类
 */
class HomeService extends BaseService
{
    /**
     * 获取统计数据
     *
     * @return void
     */
    public static function statisticData()
    {
        return [];
    }
}
