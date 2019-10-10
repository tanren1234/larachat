<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('im_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32)->comment('群组名称');
            $table->bigInteger('creator')->unsigned()->index()->comment('创建者');
            $table->string('qrcode',255)->default('')->comment('群二维码');
            $table->text('notice')->nullable()->comment('群公告');
            $table->timestamps();
        });

        Schema::create('im_group_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->comment('用户id');
            $table->bigInteger('group_id')->unsigned()->comment('群id');
            $table->string('user_group_name')->comment('用户在群组的昵称');
            $table->unique(['user_id','group_id']);
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('im_groups')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('im_conversations', function (Blueprint $table) {
            //
            $table->tinyInteger('type')->default(1)->comment('会话类型，1：单聊 2：群聊');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('im_groups');
        Schema::dropIfExists('im_group_users');
        Schema::table('im_conversations', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
