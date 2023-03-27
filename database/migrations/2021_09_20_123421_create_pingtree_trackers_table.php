<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePingtreeTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pingtree_trackers', function (Blueprint $table) {
            $table->id();
            $table->char('vid')->nullable();
            $table->unsignedBigInteger('buyersetup_id');
            $table->float('epl');
            $table->timestamps();

            $table->foreign('buyersetup_id')->references('id')->on('buyer-setup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pingtree_trackers');
    }
}
