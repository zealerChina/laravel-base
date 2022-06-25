<?php

namespace App\Admin\Controllers;

use App\Services\ConfigService;
use Illuminate\Http\Request;

/**
 * 配置管理控制器
 * 
 * @author fy
 */
class ConfigController extends Controller
{
    /**
     * 系统配置页面
     *
     * @param Request $request
     * @return void
     */
    public function system(Request $request)
    {
        $data = ConfigService::get('system');
        
        return ConfigService::success($data);
    }

    /**
     * 系统配置提交
     *
     * @param Request $reuqest
     * @return void
     */
    public function systemPost(Request $reuqest)
    {
        $data = $reuqest->only([
            'system_name'
        ]);

        $result = ConfigService::set('system', $data);

        return $result;
    }
    
    /**
     * 系统配置页面
     *
     * @param Request $request
     * @return void
     */
    public function wechat(Request $request)
    {
        $data = ConfigService::get('wechat');
        
        return ConfigService::success($data);
    }

    /**
     * 系统配置提交
     *
     * @param Request $reuqest
     * @return void
     */
    public function wechatPost(Request $reuqest)
    {
        $data = $reuqest->only([
            'app_id',
            'app_secret',
        ]);

        $result = ConfigService::set('wechat', $data);

        return $result;
    }
    
    /**
     * 系统配置页面
     *
     * @param Request $request
     * @return void
     */
    public function wechatpay(Request $request)
    {
        $data = ConfigService::get('wechatpay');
        
        return ConfigService::success($data);
    }

    /**
     * 系统配置提交
     *
     * @param Request $reuqest
     * @return void
     */
    public function wechatpayPost(Request $reuqest)
    {
        $data = $reuqest->only([
            'app_id',
            'mch_id',
            'app_secret',
            'pay_sign_key',
            'apiclient_cert',
            'apiclient_key',
        ]);

        $result = ConfigService::set('wechatpay', $data);

        return $result;
    }
    
    /**
     * 系统配置页面
     *
     * @param Request $request
     * @return void
     */
    public function sms(Request $request)
    {
        $data = ConfigService::get('sms');
        
        return ConfigService::success($data);
    }

    /**
     * 系统配置提交
     *
     * @param Request $reuqest
     * @return void
     */
    public function smsPost(Request $reuqest)
    {
        $data = $reuqest->only([
            'access_key_id',
            'access_key_secret',
            'smssign',
            'register_template_id'
        ]);

        $result = ConfigService::set('sms', $data);

        return $result;
    }
}
