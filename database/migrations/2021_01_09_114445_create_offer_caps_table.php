<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferCapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_caps', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();

            $table->char('daytotal')->nullable();

            $table->char('daylimit')->nullable();
            $table->char('weeklimit')->nullable();
            $table->char('monthlimit')->nullable();

            $table->char('daycredit')->nullable();
            $table->char('weekcredit')->nullable();
            $table->char('monthcredit')->nullable();

//            $table->char('countries')->nullable();
            $table->char('status')->nullable();

            $table->timestamps();

//            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_caps');
    }
}
