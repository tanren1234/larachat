<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('im_conversation_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_id')->unique()->comment('群组id');
            $table->bigInteger('conversation_id')->unique()->comment('会话ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('im_conversation_groups');
    }
}
