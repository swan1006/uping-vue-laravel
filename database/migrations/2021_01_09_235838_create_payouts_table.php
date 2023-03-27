<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();
            $table->char('payoutType', 50)->default('cps_cost_per_sale')->nullable();
            $table->char('payoutAmount')->nullable();
            $table->char('revenueType', 50)->default('revenue_per_sale')->nullable();
            $table->char('revenueAmount')->nullable();
            $table->char('currency')->nullable();;
            $table->char('payment_terms')->nullable();
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
        Schema::dropIfExists('payouts');
    }
}
