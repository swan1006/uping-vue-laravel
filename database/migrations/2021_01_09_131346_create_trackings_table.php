<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();
            $table->char('tracking_url')->nullable();
            $table->char('parallel_tracking_url')->nullable();
            $table->char('preview_url')->nullable();
            $table->char('tracking_domain_url')->nullable();
            $table->char('session_lifespan')->nullable();
            $table->char('status')->nullable();
            $table->timestamps();


//            $table->foreign('offer_id')->references('id')
//                ->on('offers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trackings');
    }
}
