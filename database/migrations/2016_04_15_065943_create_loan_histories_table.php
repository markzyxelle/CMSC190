<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('loan_id')->unsigned();
            $table->string('status');
            $table->double('principal_amount', 21, 4);
            $table->double('interest_amount', 21, 4);
            $table->double('principal_balance', 21, 4);
            $table->double('interest_balance', 21, 4);
            $table->date('date');
            $table->timestamps();
        });
        Schema::table('loan_histories', function (Blueprint $table) {
            $table->foreign('loan_id')->references('id')->on('loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loan_histories');
        Schema::drop('transactions');
        Schema::drop('loans');
    }
}
