@extends('base.layout')
@section('title', '用户列表')

@section('content')
<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">用户列表</div>
        <div class="layui-card-body">
            <button class="layui-btn" id="create"><i class="fas fa-plus-circle"></i>添加</button>
            <form class="layui-form" style="float:right">
                <div class="layui-form-item">
                    <div class="layui-input-inline">
                        <input type="text" name="nick_name" class="layui-input" placeholder="请输入昵称">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="mobile" class="layui-input" placeholder="请输入手机号">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="real_name" class="layui-input" placeholder="请输入真实姓名">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="invite_code" class="layui-input" placeholder="请输入邀请码">
                    </div>
                    <div class="layui-inline">
                        <select name="gender" lay-search>
                            <option value="">请选择性别</option>
                            <option value="male">男性</option>
                            <option value="female">女性</option>
                            <option value="secret">未知</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="status" lay-search>
                            <option value="">请选择状态</option>
                            <option value="normal">正常</option>
                            <option value="freeze">冻结</option>
                        </select>
                    </div>
                    <button type="submit" class="layui-btn" lay-submit>搜索</button>
                </div>
            </form>
            <table id="user" class="layui-table" lay-filter="user"></table>
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
                table.reload('user');
            }
        };

        // 搜索表单提交事件
        form.on('submit', function (e) {
            table.reload('user', {
                where: e.field,
                page: { curr: 1 },
            });

            return false;
        });

        var loading = layer.load(2);
        table.render({
            elem: '#user',
            url: "{{ route('user.index') }}",
            page: { layout: ['refresh', 'prev', 'page', 'next', 'skip', 'limit', 'count'] },
            limit: 20,
            limits: [20, 40, 60, 80, 100],
            cols: [[
                { field: 'nick_name', title: '昵称' },
                { field: 'mobile', title: '手机号' },
                { field: 'real_name', title: '真实姓名' },
                { field: 'card_no', title: '身份证号' },
                { field: 'gender', title: '性别' },
                { field: 'consume', title: '总消费' },
                { field: 'status', title: '状态' },
                { field: 'invite_code', title: '邀请码' },
                { field: 'invited_by', title: '邀请人' },
                { field: 'updated_at', title: '操作时间' },
                { field: 'operation', title: '操作', templet: '#operationTpl'}
            ]],
            done: function () {
                layer.close(loading);

                $('.layui-btn-danger').on('click', function () {
                    var that = this;

                    layer.confirm('<p>确定要删除此用户吗？</p>', { icon: 3, title: '用户删除' }, function (index) {
                        $.ajax({
                            url: "/user/" + $(that).data('user'),
                            method: "delete",
                            dataType: "json"
                        }).done(function (data) {
                            if (data.code == 0) {
                                layer.close(index);

                                layer.open({
                                    title: '删除成功',
                                    icon: 1,
                                    content: '该用户删除成功',
                                    end: function () {
                                        table.reload('user');
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

                $('button.show').on('click', function () {
                    parent.layui.index.openTabsPage($(this).attr('lay-href'), '用户查看');
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
                            url: "/user/" + $(that).data('user') + '/changestatus',
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
                                        table.reload('user');
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
        parent.layui.index.openTabsPage('user/create.html', '用户添加');
    });
</script>
<script type="text/html" id="operationTpl">
    <button type="button" class="layui-btn layui-btn-xs layui-btn-primary show" lay-href="/user/@{{ d.id }}">
        查看
    </button>
    <button type="button" class="layui-btn layui-btn-xs layui-btn-success chagnestatus" lay-href="/user/@{{ d.id }}/changestatus" data-user="@{{ d.id }}" data-status="@{{d.status}}">
        @{{# if(d.status == '正常') { }}
            <span>冻结</span>
        @{{# } else { }}
            <span>恢复</span>
        @{{# } }}
    </button>
    <button class="layui-btn layui-btn-xs layui-btn-danger"  data-user="@{{ d.id }}">
        删除
    </button>
</script>
@endpush