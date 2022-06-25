<?php

namespace App\Services;

/**
 * 基础服务类
 * 
 * @author fy
 */
class BaseService
{
    /**
     * 返回正确的消息格式
     *
     * @param array $data       数据
     * @param string $message   消息
     * @param int $code         错误码
     *
     * @return array
     */
    public static function success($data = [], string $message='', $code = 0)
    {
        return compact('code', 'data', 'message');
    }

    /**
     * 返回错误的消息格式
     *
     * @param string $message   消息
     * @param array $data       数据
     * @param int $code         错误码
     *
     * @return array
     */
    public static function error(string $message='', $code = -1, $data = [])
    {
        return compact('code', 'data', 'message');
    }
}
