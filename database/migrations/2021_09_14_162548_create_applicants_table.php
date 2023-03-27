<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
//            $table->id();
            $table->string('lead_id')->nullable();
//            $table->id();

//            $table->uuid('lead_id');

            $table->string('nameTitle')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->integer('dateOfBirthDay')->nullable();
            $table->integer('dateOfBirthMonth')->nullable();
            $table->integer('dateOfBirthYear')->nullable();
            $table->string('email')->nullable();
            $table->char('gender')->nullable();
            $table->char('cellPhoneNumber')->nullable();
            $table->char('mobilePhoneNumber')->nullable();
            $table->char('homePhoneNumber')->nullable();
            $table->char('workPhoneNumber')->nullable();
            $table->char('maritalStatus')->nullable();
            $table->integer('dependants')->nullable();
            $table->char('ssn')->nullable();
            $table->char('drivingLicenseNumber')->nullable();
            $table->char('drivingLicenseState')->nullable();
            $table->char('inMilitary')->nullable();
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
        Schema::dropIfExists('applicants');
    }
}
