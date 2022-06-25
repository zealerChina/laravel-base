<?php

namespace App\Admin\Controllers;

use App\Models\News;
use App\Resources\NewsCollection;
use App\Services\NewsService;
use Illuminate\Http\Request;

/**
 * 公告控制器
 * 
 * @author fy
 */
class NewsController extends Controller
{
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

        $banners = NewsService::paginate($params, $page, $limit);

        return new NewsCollection($banners);
    }

    /**
     * 新增公告保存方法
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'content',
            'image',
            'is_top',
            'order'
        ]);

        $result = NewsService::add($data);

        return $result;
    }

    /**
     * 编辑公告
     *
     * @param Request $request
     * @param News $news
     * @return void
     */
    public function edit(Request $request, News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * 编辑提交
     *
     * @param Request $request
     * @param News $news
     * @return void
     */
    public function update(Request $request, News $news)
    {
        $data = $request->only([
            'title',
            'content',
            'image',
            'is_top',
            'order'
        ]);

        return NewsService::update($news, $data);
    }

    /**
     * 删除公告
     *
     * @param News $news
     * @return void
     */
    public function destroy(News $news)
    {
        return NewsService::destroy($news);
    }
}
