<?php

namespace App\Services;

use App\Models\News;

/**
 * 公告服务类
 */
class NewsService extends BaseService
{
    /**
     * 公告列表
     *
     * @param array $condition
     * @param integer $page
     * @param integer $limit
     * @return void
     */
    public static function paginate($params=[], $page=1, $limit=20, $isApi=0)
    {
        $result = News::orderBy('is_top', 'desc')
                    ->orderBy('order', 'desc')
                    ->orderBy('id', 'desc')
                    ->when($params['title'] ?? '', function ($query, $title) {
                        $query->where('title', 'like', '%'.$title.'%');
                    })->when($params['is_top'] ?? '', function ($query, $is_top) {
                        $query->where('is_top', $is_top);
                    })->paginate($limit, ['*'], 'page', $page);

        if ($isApi) {
            return self::success($result);
        }

        return $result;
    }

    /**
     * 新增公告
     *
     * @param array $data
     * @return void
     */
    public static function add($data=[])
    {
        News::create($data);

        return self::success();
    }

    /**
     * 更新
     *
     * @param News $news
     * @param array $data
     * @return void
     */
    public static function update($news, $data=[])
    {
        $news->update($data);

        return self::success();
    }

    /**
     * Undocumented function
     *
     * @param [type] $news
     * @return void
     */
    public static function destroy($news)
    {
        $news->delete();

        return self::success();
    }
}
