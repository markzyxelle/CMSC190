<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->date('date');
            $table->timestamps();
        });
        Schema::table('client_histories', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('client_statuses');
            $table->foreign('client_id')->references('id')->on('clients');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client_histories');
    }
}
