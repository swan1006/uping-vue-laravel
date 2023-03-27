<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('vid')->nullable();
            $table->integer('oid')->nullable();
            $table->integer('transaction_id')->nullable();
            $table->integer('country_code')->nullable();
            $table->integer('data')->nullable();
            $table->integer('response_code')->nullable();
            $table->integer('response')->nullable();
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
        Schema::dropIfExists('lead_logs');
    }
}
