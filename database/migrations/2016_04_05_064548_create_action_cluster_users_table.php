<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionClusterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_cluster_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('action_id')->unsigned();
            $table->bigInteger('cluster_user_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('action_cluster_users', function (Blueprint $table) {
            $table->foreign('action_id')->references('id')->on('actions');
            $table->foreign('cluster_user_id')->references('id')->on('cluster_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('action_cluster_users');
    }
}
