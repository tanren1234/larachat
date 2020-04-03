<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlToImMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('im_messages', function (Blueprint $table) {
            $table->string('url')->comment('url');
            $table->string('cover_pic')->comment('封面图片');
            $table->text('extra')->comment('额外信息 longitude:经度 latitude:纬度 memo:简单描述 amount:其它与数字相关的');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('im_messages', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('cover_pic');
            $table->dropColumn('extra');
        });
    }
}
