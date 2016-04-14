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
        Schema::create('clients', function (Blueprint $table) {        //status and house address
            $table->bigIncrements('id');
            $table->bigInteger('barangay_id')->unsigned()->nullable();            //edit  11  not yet done   /
            $table->bigInteger('group_id')->unsigned();                 //edit   from variable   /
            $table->integer('status_id')->unsigned()->nullable();       //12   not yet done    
            $table->integer('gender_id')->unsigned();           //edit  7      /
            $table->integer('civil_status_id')->unsigned();     //edit  8      /
            $table->integer('beneficiary_type_id')->unsigned()->nullable(); //edit    /
            $table->string('birthplace')->nullable();  //edit   6    /
            $table->string('personal_id')->nullable();  //9     \
            $table->string('national_id')->nullable();  //        \
            $table->string('uploaded_id')->nullable();      //0      \
            $table->string('first_name');                   //3      /
            $table->string('middle_name');                  //4      /
            $table->string('last_name');                    //2      /
            $table->string('suffix', 10)->nullable();       //       /
            $table->string('mother_middle_name')->nullable(); //     /
            $table->date('birthdate');                      //5      /
            $table->string('house_address');                 //10
            $table->string('mobile_number', 15)->nullable();            //should be nullable  put 0 first    /
            $table->boolean('isDummy');                     //       /
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
