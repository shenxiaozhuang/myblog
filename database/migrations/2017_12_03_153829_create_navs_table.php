<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('nav_id');
            $table->string('nav_name', 50)->default('')->comment('//自定义导航名称');
            $table->string('nav_alias', 50)->default('')->comment('//自定义导航别名');
            $table->string('nav_url')->default('')->comment('//自定义导航url');
            $table->integer('nav_order')->default(0)->comment('//自定义导航排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('navs');
    }
}
