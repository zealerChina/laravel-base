@extends('base.layout')
@section('title', '短信列表')

@section('content')
<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">短信列表</div>
        <div class="layui-card-body">
            <!-- <button class="layui-btn" id="create"><i class="fas fa-plus-circle"></i>添加</button> -->
            <form class="layui-form" style="float:right">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <select name="type" lay-search>
                            <option value="">请选择类型</option>
                            @foreach ($typeData as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="status" lay-search>
                            <option value="">请选择状态</option>
                            @foreach ($statusData as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="mobile" class="layui-input" placeholder="手机号">
                    </div>
                    <button type="submit" class="layui-btn" lay-submit>搜索</button>
                </div>
            </form>
            <table id="sms" class="layui-table" lay-filter="sms"></table>
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

        // 短信监听
        window.onmessage = function (e) {
            if (e.origin !== window.location.origin) return;

            if (e.data == 'refresh') {
                table.reload('sms');
            }
        };

        // 搜索表单提交事件
        form.on('submit', function (e) {
            table.reload('sms', {
                where: e.field,
                page: { curr: 1 },
            });

            return false;
        });

        var loading = layer.load(2);
        table.render({
            elem: '#sms',
            url: "{{ route('sms.index') }}",
            page: { layout: ['refresh', 'prev', 'page', 'next', 'skip', 'limit', 'count'] },
            limit: 20,
            limits: [20, 40, 60, 80, 100],
            cols: [[
                { field: 'id', title: 'ID' },
                { field: 'mobile', title: '手机号' },
                { field: 'code', title: '验证码' },
                { field: 'type', title: '类型' },
                { field: 'status', title: '状态' },
                { field: 'content', title: '内容' },
                { field: 'updated_at', title: '操作时间' },
            ]],
            done: function () {
                layer.close(loading);
            }
        });
    });
</script>
@endpush