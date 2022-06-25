<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('')->comment('标题');
            $table->string('image')->default('')->comment('图片');
            $table->text('content')->nullable()->comment('内容');
            $table->tinyInteger('is_top')->default(0)->comment('是否置顶: 0.不是, 1.是');
            $table->integer('order')->default(0)->comment('排序: 由大到小道墟');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `news` comment '新闻表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
