<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residences', function (Blueprint $table) {
//            $table->id()->primary();
            $table->id();
            $table->string('lead_id')->nullable();

            $table->char('houseNumber')->nullable();
            $table->char('houseName')->nullable();
            $table->char('flatNumber')->nullable();
            $table->char('addressStreet1')->nullable();
            $table->char('addressStreet2')->nullable();
            $table->char('city')->nullable();
            $table->char('state')->nullable();
            $table->char('county')->nullable();
            $table->char('zip')->nullable();
            $table->char('postcode')->nullable();
            $table->char('residentialStatus')->nullable();
            $table->integer('monthsAtAddress')->nullable();
            $table->integer('numberOfAdults')->nullable();
            $table->integer('typeOfHousing')->nullable();
            $table->integer('numberOfRenters')->nullable();
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
        Schema::dropIfExists('residences');
    }
}
