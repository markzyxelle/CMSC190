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
            $table->bigInteger('barangay_code');            //edit
            $table->bigInteger('group_id');                 //edit
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
            $table->enum('gender', ['male', 'female']);
            $table->enum('civil_status', ['single', 'married', 'separated', 'widowed']);
            $table->string('mobile_number', 15);
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
