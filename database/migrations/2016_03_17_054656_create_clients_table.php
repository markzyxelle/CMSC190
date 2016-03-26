<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('barangay_id')->unsigned();            //edit
            $table->bigInteger('group_id')->unsigned();                 //edit
            $table->integer('status_id')->unsigned();
            $table->integer('gender_id')->unsigned();           //edit
            $table->integer('civil_status_id')->unsigned();     //edit
            $table->integer('beneficiary_type_id')->unsigned(); //edit
            $table->integer('birthplace')->unsigned();  //edit
            $table->string('personal_id')->nullable();
            $table->string('national_id')->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('suffix', 10)->nullable();
            $table->string('mother_middle_name')->nullable();
            $table->date('birthdate');
            $table->string('house_number');
            $table->string('street');
            $table->string('mobile_number', 15);
            $table->boolean('isDummy');
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
        //Schema::drop('clients');
    }
}
