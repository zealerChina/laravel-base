<?php

namespace App\Services;

use App\Models\Config;
use App\Models\House;

/**
 * 配置服务类
 * 
 * @author fy
 */
class ConfigService extends BaseService
{
    /**
     * 设置配置项
     *
     * @param string    $module    模块
     * @param array     $data      数据
     * @return array
     */
    public static function set($module='', $data=[])
    {
        if (empty($module) || empty($data)) {
            return self::error('模块或数据为空');
        }

        collect($data)->map(function ($value, $key) use ($module) {
            if (!is_null($value)) {
                Config::updateOrCreate([
                    'module' => $module,
                    'key' => $key
                ], [
                    'value' => $value
                ]);
            }
        });

        return self::success();
    }

    /**
     * 获取配置信息
     *
     * @param string $module    模块
     * @param string $key       键值
     * @param string $default   默认值
     * @return array
     */
    public static function get($module='', $key='', $default='')
    {
        if (empty($module)) {
            return self::error('请输入模块数据');
        }

        // 如果key为空, 则, 获取该模块下所有数据, 如果不为空, 则获取对应键值数据
        $condition = [
            'module' => $module
        ];
        if (!empty($key)) {
            $condition['key'] = $key;

            $result = Config::where($condition)->value('value');
        } else {
            $result = Config::where($condition)
                        ->pluck('value', 'key')
                        ->toArray();
        }

        return $result ?: $default;
    }

    /**
     * 获取系统名称
     *
     * @return string
     */
    public static function getSystemName()
    {
        return self::get('system', 'system_name', '');
    }
}
