<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LmsPartnerLeadtype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_partner_leadtype', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('vendor_id')->nullable();
          $table->integer('lead_type')->nullable();
          $table->integer('status')->nullable();
          $table->char('margin')->nullable();
          $table->char('daytotal', 255)->nullable();
          $table->char('duplicateEmail', 255)->nullable();
          $table->char('duplicatePhone', 255)->nullable();
          $table->integer('daylimit')->nullable();
          $table->integer('weeklimit')->nullable();
          $table->integer('monthlimit')->nullable();
          $table->integer('daycredit')->nullable();
          $table->integer('weekcredit')->nullable();
          $table->integer('monthcredit')->nullable();
          $table->integer('daylimitUsed')->nullable();
          $table->integer('weeklimitUsed')->nullable();
          $table->integer('monthlimitUsed')->nullable();
          $table->integer('daycreditUsed')->nullable();
          $table->integer('weekcreditUsed')->nullable();
          $table->integer('monthcreditUsed')->nullable();
          $table->float('thresoldAmount')->nullable();
          $table->char('currencyType', 255)->nullable();
          $table->float('accumulatorAmount')->nullable();
          $table->float('accuCPAuk65')->nullable();
          $table->float('accuCPAus100')->nullable();
          $table->float('accuCPLuk9')->nullable();
          $table->float('accuCPLus20')->nullable();
          $table->timestamps();

          $table->foreign('vendor_id')
              ->references('id')
              ->on('partners')
              ;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
