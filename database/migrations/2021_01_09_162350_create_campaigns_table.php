<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{

    /**
     * Car Finance Module Ping
     * Life Insurance
     *
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();
//
            $table->char('campaign_name', 255)->nullable();
            $table->char('campaign_url', 255)->nullable();
            $table->char('domain', 255)->nullable();;
            $table->integer('status');

            $table->timestamps();

//            $table->foreign('offer_id')->references('id')->on('offers');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
