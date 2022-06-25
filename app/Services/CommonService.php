<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

/**
 * 公共服务类
 */
class CommonService extends BaseService
{
    const SN_TYPES = [
        'product' => 1,
        'order' => 2,
    ];

    /**
     * 上传文件
     *
     * @param [type] $file
     * @param string $path
     * @param string $disk
     * @return void
     */
    public static function upload($file, $path='avatars', $disk='public')
    {
        $data = $file->store($path, $disk);
        $fullPath = '/storage/'.$data;

        return self::success($fullPath, '上传成功');
    }

    /**
     * 上传文件
     *
     * @param [type] $file
     * @param string $path
     * @param string $disk
     * @return void
     */
    public static function layEditUpload($file, $path='images', $disk='public')
    {
        $data = $file->store($path, $disk);
        $fullPath = '/storage/'.$data;
        $title = str_replace($path.'/', '', $data);

        return [
            'code' => 0,
            'msg' => '上传成功',
            'data' => [
                'src' => $fullPath,
                'title' => $title
            ]
        ];
    }

    /**
     * 生成编号
     *
     * @param [type] $type
     * @return void
     */
    public static function makeSn($type='product')
    {
        $typeData = self::SN_TYPES[$type] ?? 0;

        return date('YmdHis').$typeData.mt_rand(1000, 9999);
    }
}
