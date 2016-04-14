<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClusterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cluster_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cluster_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('isApproved');
            $table->timestamps();
        });
        Schema::table('cluster_users', function (Blueprint $table) {
            $table->foreign('cluster_id')->references('id')->on('clusters');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cluster_users');
    }
}
