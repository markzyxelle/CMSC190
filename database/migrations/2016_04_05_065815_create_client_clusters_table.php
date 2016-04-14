<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientClustersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_clusters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('cluster_id')->unsigned();
            $table->bigInteger('branch_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('client_clusters', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('cluster_id')->references('id')->on('clusters');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client_clusters');
    }
}
