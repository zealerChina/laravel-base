@extends('base.layout')
@section('title', '管理员列表')

@section('content')
<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">管理员列表</div>
        <div class="layui-card-body">
            <button class="layui-btn" id="create"><i class="fas fa-plus-circle"></i>添加</button>
            <form class="layui-form" style="float:right">
                <div class="layui-form-item">
                    <div class="layui-input-inline">
                        <input type="text" name="name" class="layui-input" placeholder="请输入管理员名称">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="mobile" class="layui-input" placeholder="请输入手机号">
                    </div>
                    <button type="submit" class="layui-btn" lay-submit>搜索</button>
                </div>
            </form>
            <table id="adminuser" class="layui-table" lay-filter="adminuser"></table>
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

        // 消息监听
        window.onmessage = function (e) {
            if (e.origin !== window.location.origin) return;

            if (e.data == 'refresh') {
                table.reload('adminuser');
            }
        };

        // 搜索表单提交事件
        form.on('submit', function (e) {
            table.reload('adminuser', {
                where: e.field,
                page: { curr: 1 },
            });

            return false;
        });

        var loading = layer.load(2);
        table.render({
            elem: '#adminuser',
            url: "{{ route('adminuser.index') }}",
            page: { layout: ['refresh', 'prev', 'page', 'next', 'skip', 'limit', 'count'] },
            limit: 20,
            limits: [20, 40, 60, 80, 100],
            cols: [[
                { field: 'name', title: '管理员名称' },
                { field: 'mobile', title: '手机号' },
                { field: 'status', title: '状态' },
                { field: 'updated_at', title: '操作时间' },
                { field: 'operation', title: '操作', templet: '#operationTpl' }
            ]],
            done: function () {
                layer.close(loading);

                $('.layui-btn-danger').on('click', function () {
                    var that = this;

                    layer.confirm('<p>确定要删除此管理员吗？</p>', { icon: 3, title: '管理员删除' }, function (index) {
                        $.ajax({
                            url: "/adminuser/" + $(that).data('adminuser'),
                            method: "delete",
                            dataType: "json"
                        }).done(function (data) {
                            if (data.code == 0) {
                                layer.close(index);

                                layer.open({
                                    title: '删除成功',
                                    icon: 1,
                                    content: '该管理员删除成功',
                                    end: function () {
                                        table.reload('adminuser');
                                    }
                                });
                            } else {
                                layer.msg(data.message);
                            }
                        }).fail(function (xhr) {
                            layer.msg('删除失败，请重试');
                        });
                    });
                });

                $('button.edit').on('click', function () {
                    parent.layui.index.openTabsPage($(this).attr('lay-href'), '管理员编辑');
                });

                $('button.chagnestatus').on('click', function () {
                    var that = this;
                    if ($(that).data('status') == '正常') {
                        var title_content = '冻结';
                    } else {
                        var title_content = '恢复';
                    }

                    layer.confirm('<p>确定要'+title_content+'此用户吗？</p>', { icon: 3, title: title_content }, function (index) {
                        $.ajax({
                            url: "/adminuser/" + $(that).data('user') + '/changestatus',
                            method: "get",
                            dataType: "json"
                        }).done(function (data) {
                            if (data.code == 0) {
                                layer.close(index);

                                layer.open({
                                    title: title_content+'成功',
                                    icon: 1,
                                    content: '该用户'+title_content+'成功',
                                    end: function () {
                                        table.reload('adminuser');
                                    }
                                });
                            } else {
                                layer.msg(data.message);
                            }
                        }).fail(function (xhr) {
                            layer.msg(title_content+'失败，请重试');
                        });
                    });
                });
            }
        });
    });

    // 新增按钮点击事件
    $("button#create").on('click', function () {
        parent.layui.index.openTabsPage('adminuser/create.html', '管理员添加');
    });
</script>
<script type="text/html" id="operationTpl">
    <button type="button" class="layui-btn layui-btn-xs layui-btn-primary edit" lay-href="/adminuser/@{{ d.id }}/edit.html">
        <i class="fas fa-pencil-alt"></i> 编辑
    </button>
    <button type="button" class="layui-btn layui-btn-xs layui-btn-success chagnestatus" lay-href="/user/@{{ d.id }}/changestatus" data-user="@{{ d.id }}" data-status="@{{d.status}}">
        <i class="fa fa-asterisk"></i>
        @{{# if(d.status == '正常') { }}
            <span>冻结</span>
        @{{# } else { }}
            <span>恢复</span>
        @{{# } }}
    </button>
    <button class="layui-btn layui-btn-xs layui-btn-danger"  data-adminuser="@{{ d.id }}">
        <i class="far fa-trash-alt"></i> 删除
    </button>
</script>
@endpush