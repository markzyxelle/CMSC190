<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyRoleActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_role_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_role_id')->unsigned();
            $table->bigInteger('activity_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('company_role_activities', function (Blueprint $table) {
            $table->foreign('company_role_id')->references('id')->on('company_roles');
            $table->foreign('activity_id')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company_role_activities');
    }
}
