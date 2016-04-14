<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditClientsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('barangay_id')->references('id')->on('barangays');
            $table->foreign('status_id')->references('id')->on('client_statuses');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('civil_status_id')->references('id')->on('civil_statuses');
            $table->foreign('beneficiary_type_id')->references('id')->on('beneficiary_types');
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
