<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('module', 100)->default('')->comment('模块');
            $table->string('key', 100)->default('')->comment('键值');
            $table->longText('value')->nullable()->comment('值');
            $table->tinyInteger('is_json')->default(0)->comment('是否是json串: 0.不是, 1.是');
            $table->string('description')->default('')->comment('描述');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `configs` comment '配置表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
