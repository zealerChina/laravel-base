<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0)->comment('父类ID');
            $table->integer('order')->default(0)->comment('排序');
            $table->string('title', 100)->default('')->comment('标题');
            $table->string('icon', 100)->default('')->comment('图标');
            $table->string('icon_selected', 100)->default('')->comment('选中图标');
            $table->string('uri')->nullable();
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_menus` comment '菜单表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menus');
    }
}
