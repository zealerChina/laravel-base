<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_records', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 20)->default('')->comment('手机号');
            $table->string('code', 20)->default('')->comment('验证码');
            $table->enum('type', ['register'])->default('register')->comment('短信类型: register.注册');
            $table->enum('status', ['unsend', 'success', 'fail'])->default('unsend')->comment('状态: unsend.待发送, success.发送成功, fail.发送失败');
            $table->text('content')->nullable()->comment('内容');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `sms_records` comment '短信发送记录表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_records');
    }
}
