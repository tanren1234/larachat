<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 会话表
        Schema::create('im_conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('private')->default(true);
            $table->text('data')->nullable();
            $table->timestamps();
        });

        // 消息表
        Schema::create('im_messages',function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('body');
            $table->bigInteger('conversation_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('type')->default('text');
            $table->timestamps();
            $table->index(['conversation_id','user_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('conversation_id')
                ->references('id')
                ->on('im_conversations')
                ->onDelete('cascade');
        });

        // 会话用户关联表
        Schema::create('im_conversation_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('conversation_id')->unsigned();
            $table->primary(['user_id', 'conversation_id']);
            $table->timestamps();

            $table->foreign('conversation_id')
                ->references('id')->on('im_conversations')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        // 消息通知表
        Schema::create('im_message_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('message_id')->unsigned();
            $table->bigInteger('conversation_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('is_seen')->default(false); // 是否收到
            $table->boolean('is_sender')->default(false); // 是否是发送者
            $table->boolean('flagged')->default(false); // 是否已标记
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'message_id','conversation_id']);

            $table->foreign('message_id')
                ->references('id')->on('im_messages')
                ->onDelete('cascade');

            $table->foreign('conversation_id')
                ->references('id')->on('im_conversations')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('im_conversations');
        Schema::dropIfExists('im_messages');
        Schema::dropIfExists('im_conversation_user');
        Schema::dropIfExists('im_message_notification');
    }
}
