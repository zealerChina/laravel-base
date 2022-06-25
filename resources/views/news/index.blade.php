@extends('base.layout')
@section('title', '新闻热点列表')

@section('content')
<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">新闻热点列表</div>
        <div class="layui-card-body">
            <button class="layui-btn" id="create"><i class="fas fa-plus-circle"></i>添加</button>
            <form class="layui-form" style="float:right">
                <div class="layui-form-item">
                    <div class="layui-input-inline">
                        <input type="text" name="title" class="layui-input" placeholder="标题">
                    </div>
                    <button type="submit" class="layui-btn" lay-submit>搜索</button>
                </div>
            </form>
            <table id="news" class="layui-table" lay-filter="news"></table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    layui.use(['laydate', 'table', 'form'], function () {
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;

        // 新闻热点监听
        window.onmessage = function (e) {
            if (e.origin !== window.location.origin) return;

            if (e.data == 'refresh') {
                table.reload('news');
            }
        };

        // 搜索表单提交事件
        form.on('submit', function (e) {
            table.reload('news', {
                where: e.field,
                page: { curr: 1 },
            });

            return false;
        });

        var loading = layer.load(2);
        table.render({
            elem: '#news',
            url: "{{ route('news.index') }}",
            page: { layout: ['refresh', 'prev', 'page', 'next', 'skip', 'limit', 'count'] },
            limit: 20,
            limits: [20, 40, 60, 80, 100],
            cols: [[
                { field: 'title', title: '标题' },
                { field: 'image', title: '图片', templet:function (d) {
                    return "<img src='"+d.image+"' >";
                } },
                { field: 'content', title: '内容' },
                { field: 'is_top', title: '是否置顶', templet: function (d) {
                    if (d.is_top == 1) {
                        return '是';
                    } else {
                        return '不是'
                    }
                } },
                { field: 'order', title: '排序' },
                { field: 'updated_at', title: '操作时间' },
                { field: 'operation', title: '操作', templet: '#operationTpl' }
            ]],
            done: function () {
                layer.close(loading);

                $('.layui-btn-danger').on('click', function () {
                    var that = this;

                    layer.confirm('<p>确定要删除此新闻热点吗？</p>', { icon: 3, title: '新闻热点删除' }, function (index) {
                        $.ajax({
                            url: "/news/" + $(that).data('news'),
                            method: "delete",
                            dataType: "json"
                        }).done(function (data) {
                            if (data.code == 0) {
                                layer.close(index);

                                layer.open({
                                    title: '删除成功',
                                    icon: 1,
                                    content: '该新闻热点删除成功',
                                    end: function () {
                                        table.reload('news');
                                    }
                                });
                            } else {
                                layer.msg(data.news);
                            }
                        }).fail(function (xhr) {
                            layer.msg('删除失败，请重试');
                        });
                    });
                });

                $('button.edit').on('click', function () {
                    parent.layui.index.openTabsPage($(this).attr('lay-href'), '新闻热点编辑');
                });
            }
        });
    });

    // 新增按钮点击事件
    $("button#create").on('click', function () {
        parent.layui.index.openTabsPage('news/create.html', '新闻热点添加');
    });
</script>
<script type="text/html" id="operationTpl">
    <button type="button" class="layui-btn layui-btn-xs layui-btn-primary edit" lay-href="/news/@{{ d.id }}/edit.html">
        <i class="fas fa-pencil-alt"></i> 编辑
    </button>
    <button class="layui-btn layui-btn-xs layui-btn-danger"  data-news="@{{ d.id }}">
        <i class="far fa-trash-alt"></i> 删除
    </button>
</script>
@endpush