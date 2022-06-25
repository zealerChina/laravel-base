@extends('base.layout')
@section('title', '配置管理')

@section('content')
<div class="layui-card">
    <div class="layui-card-header">配置管理</div>
    <div class="layui-card-body">
        <div class="layui-tab layui-tab-brief">
            <ul class="layui-tab-title">
                <li class="layui-this">系统配置</li>
                <li>微信小程序配置</li>
                <li>微信支付配置</li>
                <li>阿里云短信配置</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    @include('config.system')
                </div>
                <div class="layui-tab-item">
                    @include('config.wechat')
                </div>
                <div class="layui-tab-item">
                    @include('config.wechatpay')
                </div>
                <div class="layui-tab-item">
                    @include('config.sms')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
layui.use(['element', 'table'], function () {
    var table = layui.table;

    // 消息监听
    window.onmessage = function (e) {
        console.log('onmessage');
        if (e.origin !== window.location.origin) return;

        if (e.data == 'refresh') {
            table.reload('pending');
            table.reload('all');
        }
    };
});
</script>
@endpush
