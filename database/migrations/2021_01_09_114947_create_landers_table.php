<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landers', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();

            $table->char('lander_name')->nullable();
            $table->char('lander_internal_tracking_url')->nullable();
            $table->char('lander_tracking_url')->nullable();
            $table->char('lander_para_tracking_url')->nullable();
            $table->char('lander_preview_url')->nullable();
            $table->integer('status')->nullable();
            $table->char('lander_notes')->nullable();

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
        Schema::dropIfExists('landers');
    }
}
