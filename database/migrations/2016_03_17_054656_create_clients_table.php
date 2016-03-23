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
<<<<<<< HEAD
<<<<<<< HEAD
            $table->bigInteger('barangay_id');            //edit
            $table->bigInteger('group_id');                 //edit
            $table->integer('status_id')->unsigned();
            $table->integer('gender_id')->unsigned();           //edit
            $table->integer('civil_status_id')->unsigned();     //edit
            $table->integer('beneficiary_type_id')->unsigned(); //edit
            $table->integer('birthplace')->unsigned();  //edit
=======
            $table->bigInteger('barangay_code')->unsigned();
            $table->bigInteger('group_id')->unsigned();
>>>>>>> parent of ef9caf6... working approval of pending users
=======
            $table->bigInteger('barangay_code');            //edit
            $table->bigInteger('group_id');                 //edit
>>>>>>> parent of 33c5c37... fixed administrator approval and added roles page
            $table->string('personal_id')->nullable();
            $table->string('national_id')->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('suffix', 10)->nullable();
            $table->string('mother_middle_name')->nullable();
            $table->date('birthdate');
            $table->string('birthplace');
            $table->string('house_number');
            $table->string('street');
<<<<<<< HEAD
<<<<<<< HEAD
            $table->string('mobile_number', 15);
            $table->boolean('isDummy');
=======
            $table->enum('gender', ['male', 'female']);
            $table->enum('civil_status', ['single', 'married', 'separated', 'widowed']);
            $table->integer('mobile_number', 15);
>>>>>>> parent of ef9caf6... working approval of pending users
=======
            $table->enum('gender', ['male', 'female']);
            $table->enum('civil_status', ['single', 'married', 'separated', 'widowed']);
            $table->string('mobile_number', 15);
>>>>>>> parent of 33c5c37... fixed administrator approval and added roles page
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
        Schema::drop('clients');
    }
}
