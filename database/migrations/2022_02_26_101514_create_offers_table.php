<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->unsignedBigInteger('advertiser_id')->nullable();
            $table->unsignedBigInteger('tracking_id')->nullable();
            $table->unsignedBigInteger('target_group_id')->nullable();
            $table->unsignedBigInteger('lander_id')->nullable();
            $table->unsignedBigInteger('offer_cap_id')->nullable();
            $table->unsignedBigInteger('payout_id')->nullable();
            $table->unsignedBigInteger('offer_metric_id')->nullable();

            $table->char('name')->nullable();
            $table->char('description')->nullable();
            $table->char('internal')->nullable();
            $table->integer('thresholdAmount')->nullable();
            $table->char('expiresDate')->nullable();
            $table->char('status')->nullable();

            $table->char('logo')->default('images/avatar/default.png')->nullable();
            $table->char('privacy_level')->nullable();
            $table->char('top_offer')->nullable();
            $table->char('restrictions')->nullable();
            $table->char('conversion_action')->nullable();
            $table->char('conversion_type')->nullable();
            $table->char('multiple_conversions')->nullable();
            $table->char('terms')->nullable();


            $table->char('category')->nullable();
            $table->char('trafficSource')->nullable();
            $table->char('geos')->nullable();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('advertiser_id')->references('id')->on('advertisers')->onDelete('cascade');
            $table->foreign('tracking_id')->references('id')->on('trackings')->onDelete('cascade');
            $table->foreign('target_group_id')->references('id')->on('target_groups')->onDelete('cascade');
            $table->foreign('lander_id')->references('id')->on('landers')->onDelete('cascade');
            $table->foreign('offer_metric_id')->references('id')->on('offer_metrics')->onDelete('cascade');
            $table->foreign('offer_cap_id')->references('id')->on('offer_caps')->onDelete('cascade');
            $table->foreign('payout_id')->references('id')->on('payouts')->onDelete('cascade');

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
        Schema::dropIfExists('offers');
    }
}
