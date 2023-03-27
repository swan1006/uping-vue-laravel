<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClickTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('postback_tracker_id')->nullable();
            $table->char('advertiser_id')->nullable();
            $table->char('advertiser_ref')->nullable();
            $table->char('aff_click_id')->nullable();
            $table->char('aff_id')->nullable();
            $table->char('aff_sub')->nullable();
            $table->char('aff_sub2')->nullable();
            $table->char('aff_sub3')->nullable();
            $table->char('aff_sub4')->nullable();
            $table->char('aff_sub5')->nullable();
            $table->char('aff_unique1')->nullable();
            $table->char('aff_unique2')->nullable();
            $table->char('aff_unique3')->nullable();
            $table->char('aff_unique4')->nullable();
            $table->char('aff_unique5')->nullable();

            $table->char('affiliate_id')->nullable();
            $table->char('affiliate_name')->nullable();
            $table->char('affiliate_ref')->nullable();
            $table->char('city')->nullable();
            $table->char('country_code')->nullable();
            $table->char('currency')->nullable();
            $table->char('date')->nullable();
            $table->char('datetime')->nullable();

            $table->char('file_id')->nullable();
            $table->char('file_name')->nullable();
            $table->char('mobile_carrier')->nullable();
            $table->char('fbpix')->nullable();


            $table->char('offer_file_id')->nullable();
            $table->char('offer_id')->nullable();
            $table->char('offer_name')->nullable();
            $table->char('offer_ref')->nullable();
            $table->char('offer_url_id')->nullable();
            $table->char('payout')->nullable();

            $table->char('ran')->nullable();
            $table->char('region_code')->nullable();
            $table->char('revenue')->nullable();
            $table->char('source')->nullable();
            $table->char('time')->nullable();
            $table->char('transaction_id')->nullable();
            $table->char('ip')->nullable();
            $table->longText('user_agent')->nullable();
            $table->char('device_brand')->nullable();
            $table->char('device_model')->nullable();
            $table->char('device_os')->nullable();
            $table->char('device_os_version')->nullable();

            $table->char('google_aid')->nullable();
            $table->char('google_aid_sha1')->nullable();
            $table->char('ios_ifa')->nullable();
            $table->char('ios_ifa_sha1')->nullable();
            $table->char('ios_ifv')->nullable();
            $table->char('unid')->nullable();
            $table->char('guid')->nullable();
            $table->char('windows_aid')->nullable();
            $table->char('windows_aid_sha1')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');;
            $table->foreign('postback_tracker_id')->references('id')->on('postback_trackers')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('click_trackers');
    }
}
