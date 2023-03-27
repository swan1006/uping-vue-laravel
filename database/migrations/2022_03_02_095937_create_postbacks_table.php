<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('offer_id')->nullable();
//            $table->unsignedBigInteger('click_tracker_id')->nullable();
//            $table->unsignedBigInteger('postback_log_id')->nullable();

            $table->char('postback_name');
            $table->char('affiliatePostbackUrl');
            $table->char('conversion')->nullable();
            $table->char('totalCost')->nullable();
            $table->char('totalRevenue')->nullable();
            $table->char('global')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners');
            $table->foreign('offer_id')->references('id')->on('offers');
//            $table->foreign('click_tracker_id')->references('id')->on('click_trackers');
//            $table->foreign('postback_log_id')->references('id')->on('postback_logs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postbacks');
    }
}
