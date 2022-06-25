@extends('base.layout')
@section('title', '查看用户')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ztree@3.5.24/css/zTreeStyle/zTreeStyle.css">
<link rel="stylesheet" href="/css/formSelects-v4.css">
<style>
    .layui-form-label {
        width: 135px;
    }
    .layui-input-block {
        margin-left: 165px;
    }
</style>
@endpush

@section('content')
<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">查看用户</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="show">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">昵称 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->nick_name }}" readonly>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">手机号 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->mobile }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">真实姓名 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->real_name }}" readonly>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">身份证号 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->card_no }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">小程序unionid </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->unionid }}" readonly>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">小程序openid </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->openid }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">省 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->province }}"
                                readonly>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">市 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->city }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">区 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->area }}"
                                readonly>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">地址 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->address }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">生日 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->birthday }}"
                                readonly>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">状态 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ \App\Services\UserService::STATUS[$user->status] ?? '未知' }}"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">性别 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ \App\Services\UserService::GENDER[$user->gender] ?? '未知' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">总消费 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->consume }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">被邀请人 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->invitedBy->nick_name ?? '' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">邀请码 </label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input"  value="{{ $user->invite_code }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">图片</label>
                        <div class="layui-input-inline">
                    
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush