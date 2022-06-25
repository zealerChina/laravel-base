<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unionid')->unique()->default('')->comment('小程序unionid');
            $table->string('openid')->unique()->default('')->comment('小程序openid');
            $table->string('mobile')->unique()->default('')->comment('手机号');
            $table->string('password')->default('')->comment('密码');
            $table->string('token')->default('')->comment('Token');
            $table->string('nick_name', 50)->default('')->comment('昵称');
            $table->string('real_name', 50)->default('')->comment('真实姓名');
            $table->string('card_no', 50)->default('')->comment('身份证号');
            $table->string('avatar')->default('')->comment('头像');
            $table->string('province')->default('')->comment('省份');
            $table->string('city')->default('')->comment('城市');
            $table->string('area')->default('')->comment('地区');
            $table->string('address')->default('')->comment('地址');
            $table->date('birthday')->nullable()->comment('生日');
            $table->enum('gender', ['male', 'female', 'secret'])->default('secret')->comment('性别: male.男性, female.女性, secret.未知');
            $table->decimal('consume', 10, 2)->default('0.00')->comment('总消费');
            $table->enum('status', ['normal', 'freeze', 'deleted'])->default('normal')->comment('状态: normal.正常, freeze.冻结的, deleted.删除的');
            $table->string('invite_code', 50)->default('')->comment('邀请码');
            $table->integer('invite_id')->default(0)->comment('邀请人ID');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `users` comment '用户表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
