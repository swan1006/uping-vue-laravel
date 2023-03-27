<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();
            $table->char('target_group_name')->nullable();
            $table->integer('all_devices')->nullable();
            $table->integer('target_devices')->nullable();
            $table->char('countries')->nullable();
            $table->char('regions')->nullable();
            $table->char('cities')->nullable();;
            $table->char('connection_type')->nullable();
            $table->integer('status');;
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
        Schema::dropIfExists('target_groups');
    }
}
