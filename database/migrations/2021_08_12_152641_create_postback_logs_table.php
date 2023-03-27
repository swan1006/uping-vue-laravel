<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostbackLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postback_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('click_tracker_id')->nullable();
            $table->unsignedBigInteger('postback_tracker_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('offer_id')->nullable();

            $table->string('lead_id', 255)->nullable();
            $table->char('aff_sub', 255)->nullable();
            $table->char('aff_sub2', 255)->nullable();
            $table->char('aff_sub3', 255)->nullable();
            $table->char('aff_sub4', 255)->nullable();
            $table->char('aff_sub5', 255)->nullable();
            $table->char('affiliatePostbackUrl')->nullable();
            $table->char('transaction_id')->nullable();
            $table->char('conversion')->nullable();
            $table->float('amount')->nullable();
            $table->float('totalCost')->nullable();
            $table->float('totalRevenue')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('click_tracker_id')->references('id')->on('click_trackers');
            $table->foreign('postback_tracker_id')->references('id')->on('postback_trackers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postback_logs');
    }
}
