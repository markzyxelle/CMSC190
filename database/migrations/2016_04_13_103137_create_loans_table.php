<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned();
            $table->integer('loan_type_id')->unsigned();
            $table->integer('loan_cycle');
            $table->date('released_date')->nullable();
            $table->double('principal_amount', 21, 4);
            $table->double('interest_amount', 21, 4);
            $table->double('principal_balance', 21, 4);
            $table->double('interest_balance', 21, 4);
            $table->boolean('isActive');
            $table->boolean('isReleased');
            $table->string('status');
            $table->string('uploaded_id')->nullable();
            $table->date('maturity_date')->nullable();
            $table->date('cutoff_date');
            $table->timestamps();
        });
        Schema::table('loans', function (Blueprint $table) {
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
    }
}
