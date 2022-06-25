@extends('base.layout')
@section('title', '新闻热点编辑')

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
        <div class="layui-card-header">新闻热点编辑</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="edit">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">标题 <span style="color:#FF5722">*</span></label>
                        <div class="layui-input-inline" style="width: 600px;">
                            <input type="text" name="title" class="layui-input" lay-verType="tips" value="{{ $news->title ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">内容</label>
                        <div class="layui-input-inline" style="width: 600px;">
                            <textarea name="content" id="content" cols="30" rows="10" class="layui-textarea">{{ $news->content ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">图片</label>
                        <div class="layui-input-inline">
                            <div class="layui-upload">
                            <button type="button" class="layui-btn" id="image"><i class="layui-icon"></i>上传图片</button>
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" id="image-img" src="{{ $news->image ?? '' }}">
                                <input type="hidden" name="image" value="{{ $news->getRawOriginal('image') ?? '' }}">
                            </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">是否置顶</label>
                        <div class="layui-input-inline">
                            <input type="radio" name="is_top" value="0" title="不置顶" @if ($news->is_top == 0) checked @endif>
                            <input type="radio" name="is_top" value="1" title="置顶" @if ($news->is_top == 1) checked @endif>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">排序(由大到小) </label>
                        <div class="layui-input-inline" style="width: 600px;">
                            <input type="number" name="order" class="layui-input" lay-verType="tips" value="{{ $news->order ?? 0 }}">
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
    layui.use(['form', 'laydate', 'upload', 'layedit'], function () {
        var $ = layui.$;
        var form = layui.form;
        var layer = layui.layer;
        var admin = parent.layui.admin;
        var laydate = layui.laydate;
        var upload = layui.upload;
        var layedit = layui.layedit;

        layedit.set({
            uploadImage: {
                url: '/common/upload/layedit',
                type: 'post',
                data:{
                    path: 'images/posts'
                },
            }
        });

        var editer = layedit.build('content'); //建立编辑器

        // 表单提交事件
        form.on('submit', function (e) {
            var loading = layer.load(2);

            var content = layedit.getContent(editer);
            e.field.content = content;

            $.ajax({
                url: "/news/{{$news->id}}",
                method: "put",
                dataType: 'json',
                data: e.field,
            }).done(function (data) {
                var iframe = parent.layui.$('iframe[src="/news/index.html"]');
                if (iframe.length) {
                    iframe[0].contentWindow.postMessage('refresh', window.location.origin);
                }

                layer.open({
                    icon: 1,
                    title: '新闻热点编辑',
                    content: '新闻热点编辑成功',
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
			elem: '#image',
			url: '/common/upload',
            data: {
                path: 'images/newss'
            },
			done: function(res) {
				if (res.code >= 0) {
					$("input[name='image']").val(res.data);
                    $('#image-img').attr('src', res.data); //图片链接（base64）
				}
				return layer.msg(res.message);
			}
		});
    })
</script>
@endpush