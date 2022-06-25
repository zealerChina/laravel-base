<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->char('mobile', 11)->default('')->unique()->comment('手机号');
            $table->string('avatar')->default('')->comment('头像');
            $table->string('password', 100)->default('')->comment('密码');
            $table->enum('status', ['normal', 'freeze', 'deleted'])->default('normal')->comment('状态: normal.正常, freeze.冻结的, deleted.删除的');
            $table->rememberToken();
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_users` comment '管理员表'"); // 表注释
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
