<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
//            $table->uuid('id')->primary();
            $table->id();
            $table->string('lead_id')->nullable();

            $table->char('bankName')->nullable();
            $table->char('bankCardType')->nullable();
            $table->char('bankAccountNumber')->nullable();
            $table->char('bankRoutingNumber')->nullable();
            $table->char('bankPhone')->nullable();
            $table->char('bankAccountLength')->nullable();
            $table->char('bankAccountType')->nullable();
            $table->char('onlineBanking')->nullable();
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
        Schema::dropIfExists('banks');
    }
}
