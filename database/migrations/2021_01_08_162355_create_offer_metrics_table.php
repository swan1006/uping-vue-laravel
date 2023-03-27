<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_metrics', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();
//            $table->unsignedBigInteger('campaign_id')->nullable();

//            $table->unsignedBigInteger('lander_id')->nullable();
//            $table->unsignedBigInteger('flow_id')->nullable();
//            $table->unsignedBigInteger('traffic_source_id')->nullable();

            $table->integer('status')->nullable();
            $table->integer('mean_TTC')->nullable()->nullable();
            $table->integer('low_TTC')->nullable();
            $table->integer('high_TTC')->nullable();
            $table->integer('optimal_TTC')->nullable();

            $table->integer('visits')->nullable();
            $table->integer('sus_visits')->nullable();
            $table->integer('unique_visits')->nullable();
            $table->integer('clicks')->nullable();
            $table->integer('unique_clicks')->nullable();
            $table->integer('sus_clicks')->nullable();
            $table->integer('conversions')->nullable();

            $table->integer('install')->nullable();
            $table->integer('install_rev')->nullable();
            $table->integer('download')->nullable();
            $table->integer('download_rev')->nullable();
            $table->integer('sell')->nullable();
            $table->integer('sell_rev')->nullable();
            $table->integer('revenue')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('profit')->nullable();

            $table->integer('costPerView')->nullable();
            $table->integer('clickThroughRate')->nullable();
            $table->integer('conversionRatio')->nullable();
            $table->integer('CV')->nullable();
            $table->integer('ROI')->nullable();
            $table->integer('earningsPerClick')->nullable();
            $table->integer('earningsPerView')->nullable();
            $table->integer('earningsPerLead')->nullable();
            $table->integer('effectiveCostPerMille')->nullable();
            $table->integer('effectiveCostPerClick')->nullable();
            $table->integer('effectiveCostPerAction')->nullable();
            $table->timestamps();

//            $table->foreign('offer_id')->references('id')->on('offers');
//            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
//            $table->foreign('lander_id')->references('id')->on('landers')->onDelete('cascade');
//            $table->foreign('flow_id')->references('id')->on('flows')->onDelete('cascade');
//            $table->foreign('traffic_source_id')->references('id')->on('traffic_sources')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_metrics');
    }
}
