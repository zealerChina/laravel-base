<?php

namespace App\Admin\Controllers;
use App\Resources\SmsCollection;
use App\Services\SmsService;
use Illuminate\Http\Request;

/**
 * 订单控制器
 * 
 * @author fy
 */
class SmsController extends Controller
{
    /**
     * 列表页视图
     *
     * @param Request $request
     * @return void
     */
    public function showForm(Request $request)
    {
        $statusData = SmsService::STATUS;
        $typeData = SmsService::TYPE;

        return view('sms.index', compact('statusData', 'typeData'));
    }

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

        $result = SmsService::paginate($params, $page, $limit);

        return new SmsCollection($result);
    }
}
