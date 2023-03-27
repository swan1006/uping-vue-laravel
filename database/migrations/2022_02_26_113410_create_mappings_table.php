<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mappings', function (Blueprint $table) {
            $table->id();
            $table->char('leadtype');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('buyer_setup_id');
            $table->tinyInteger('status');

            $table->foreign('partner_id')->references('id')->on('partners');
            $table->foreign('buyer_id')->references('id')->on('buyers');
            $table->foreign('buyer_setup_id')->references('id')->on('buyer_setups');

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
        Schema::dropIfExists('mappings');
    }
}
