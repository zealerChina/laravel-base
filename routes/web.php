<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::any('test', 'TestController@index');
// 登录页面
Route::view('login', 'auth.login')->middleware('guest');
// 登录提交方法
Route::post('login','Login')->name('login')->middleware('guest');
// 退出操作
Route::get('logout', 'Logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    // 首页
    Route::view('/', 'base.main')->name('main');
    // 仪表盘页面
    Route::get('dashboard.html', 'HomeController@index')->name('dashboard');
    // 配置管理
    Route::group(['prefix' => 'config'], function () {
        Route::view('index.html', 'config.index');
        // 系统配置
        Route::get('system', 'ConfigController@system');
        Route::post('system', 'ConfigController@systemPost');
        // 微信支付配置
        Route::get('wechatpay', 'ConfigController@wechatpay');
        Route::post('wechatpay', 'ConfigController@wechatpayPost');
        // 小程序配置
        Route::get('wechat', 'ConfigController@wechat');
        Route::post('wechat', 'ConfigController@wechatPost');
        // 小程序配置
        Route::get('sms', 'ConfigController@sms');
        Route::post('sms', 'ConfigController@smsPost');
    });
    // 后台账号管理
    Route::group(['prefix' => 'adminuser', 'as' => 'adminuser.'], function () {
        Route::view('index.html', 'admin_user.index')
            ->name('indexview');
        Route::get('/', 'AdminUserController@index')
            ->name('index');
        // 管理员创建视图
        Route::view('/create.html', 'admin_user.create')
            ->name('create.html');
        // 保存管理员
        Route::post('/', 'AdminUserController@store')
            ->name('store');
        // 管理员编辑视图
        Route::get('/{user}/edit.html', 'AdminUserController@edit')
            ->name('edit.html');
        // 更新管理员
        Route::put('/{user}', 'AdminUserController@update')
            ->name('update');
        // 删除管理员
        Route::delete('/{user}', 'AdminUserController@destroy')
            ->name('destroy');
        // 冻结
        Route::get('/{user}/changestatus', 'AdminUserController@changeStatus')
            ->name('change');
    });
    // 用户管理
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        // 列表页面
        Route::view('index.html', 'user.index')
            ->name('indexview');
        // 获取数据
        Route::get('/', 'UserController@index')
            ->name('index');
        // 冻结
        Route::get('/{user}/changestatus', 'UserController@changeStatus')
            ->name('change');
        // 获取用户信息
        Route::get('/info', 'UserController@info')
            ->name('info');
        // 展示
        Route::get('/{user}', 'UserController@show')
            ->name('show');
    });
    // 公共管理
    Route::group(['prefix' => 'common', 'as' => 'common.'], function () {
        // 上传
        Route::post('upload', 'CommonController@upload')
            ->name('upload');
        // layEditUpload上传
        Route::post('upload/layedit', 'CommonController@layEditUpload')
            ->name('upload.layedit');
    });
    // 新闻管理
    Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
        Route::view('index.html', 'news.index')
            ->name('indexview');
        Route::get('/', 'NewsController@index')
            ->name('index');
        // 新闻创建视图
        Route::view('/create.html', 'news.create')
            ->name('create.html');
        // 保存新闻
        Route::post('/', 'NewsController@store')
            ->name('store');
        // 新闻编辑视图
        Route::get('/{news}/edit.html', 'NewsController@edit')
            ->name('edit.html');
        // 更新新闻
        Route::put('/{news}', 'NewsController@update')
            ->name('update');
        // 删除新闻
        Route::delete('/{news}', 'NewsController@destroy')
            ->name('destroy');
    });
    // 短信管理
    Route::group(['prefix' => 'sms', 'as' => 'sms.'], function () {
        Route::get('index.html', 'SmsController@showForm')
            ->name('indexview');
        Route::get('/', 'SmsController@index')
            ->name('index');
    });
});
