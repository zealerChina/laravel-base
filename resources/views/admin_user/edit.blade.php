@extends('base.layout')
@section('title', '管理员编辑')

@push('css')
<style>
    .layui-form-label {
        width: 100px;
    }
    .layui-input-block {
        margin-left: 130px;
    }
</style>
@endpush

@section('content')
<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">管理员编辑</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="edit">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">管理员名称 <span style="color:#FF5722">*</span></label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" class="layui-input" lay-verify="required" lay-verType="tips" value="{{ $user->name ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">管理员手机号 <span style="color:#FF5722">*</span></label>
                        <div class="layui-input-inline">
                            <input type="text" name="mobile" class="layui-input" lay-verify="required" lay-verType="tips" value="{{ $user->mobile ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="password" class="layui-input" lay-verType="tips">
                        </div>
                        <div class="layui-form-mid layui-word-aux">提示：如不需要修改密码, 则该值不填</div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">状态 <span style="color:#FF5722">*</span></label>
                        <div class="layui-input-inline">
                            <select name="status" lay-search lay-verify="required" lay-verType="tips">
                                <option value="normal" @if ($user->status == 'normal') selected='selected' @endif>正常</option>
                                <option value="freeze" @if ($user->status == 'freeze') selected='selected' @endif>冻结</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">头像</label>
                        <div class="layui-input-inline">
                            <div class="layui-upload">
                            <button type="button" class="layui-btn" id="avatar"><i class="layui-icon"></i>上传头像</button>
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" id="avatar-img" src="{{ $user->avatar ?? '' }}">
                                <input type="hidden" name="avatar" value="{{ $user->getRawOriginal('avatar') ?? '' }}">
                            </div>
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="submit">确认编辑</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    layui.use(['form', 'laydate', 'upload'], function () {
        var $ = layui.$;
        var form = layui.form;
        var layer = layui.layer;
        var admin = parent.layui.admin;
        var laydate = layui.laydate;
        var upload = layui.upload;

        // 表单提交事件
        form.on('submit', function (e) {
            var loading = layer.load(2);

            $.ajax({
                url: "/adminuser/{{$user->id}}",
                method: "put",
                dataType: 'json',
                data: e.field,
            }).done(function (data) {
                var iframe = parent.layui.$('iframe[src="/adminuser/index.html"]');
                if (iframe.length) {
                    iframe[0].contentWindow.postMessage('refresh', window.location.origin);
                }

                layer.open({
                    icon: 1,
                    title: '管理员编辑',
                    content: '管理员编辑成功',
                    end: function () {
                        admin.events.closeThisTabs();
                    }
                });
            }).fail(function (xhr) {
                var content = '';
                for (error in xhr.responseJSON.errors) {
                    content += xhr.responseJSON.errors[error][0];
                }

                layer.open({
                    title: '错误',
                    icon: 2,
                    content: content,
                });
            }).always(function () {
                layer.close(loading);
            });

            return false;
        });

        // 图片上传
        var uploadInst = upload.render({
            elem: '#avatar',
            url: '/common/upload',
            data: {
                path: 'image/avatars'
            },
            done: function(res) {
                if (res.code >= 0) {
                    $("input[name='avatar']").val(res.data);
                    $('#avatar-img').attr('src', res.data); //图片链接（base64）
                }
                return layer.msg(res.message);
            }
        });
    })
</script>
@endpush