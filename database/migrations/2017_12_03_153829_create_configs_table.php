<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->engine = 'MyISAM';

            $table->increments('config_id');
            $table->string('conf_title', 50)->default('')->comment('//配置标题');
            $table->string('conf_name', 50)->default('')->comment('//变量名');
            $table->text('conf_content')->default('')->comment('//变量值');
            $table->string('conf_tips')->default('')->comment('//描述');
            $table->string('field_type', 50)->default('')->comment('//类型');
            $table->string('field_value')->default('')->comment('//类型值');

            $table->integer('conf_order')->default(0)->comment('//配置名称');
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
