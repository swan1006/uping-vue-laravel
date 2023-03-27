<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_setups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id')->nullable();

            $table->char('leadtype', 20);
            $table->char('buyername', 255);
            $table->float('tier_price')->nullable();
            $table->char('model_type');
            $table->integer('posting_order')->default(0);
            $table->char('parameter1', 255);
            $table->char('parameter2', 255);
            $table->char('parameter3', 255);
            $table->char('ping_url_test', 255);
            $table->char('post_url_test', 255)->nullable();
            $table->char('ping_url_live', 255);
            $table->char('post_url_live', 255)->nullable();
            $table->integer('timeout')->nullable();
            $table->tinyInteger('mode')->default(2)->comment('2=test, 1=live');
            $table->tinyInteger('status')->default(1)->comment('inactive=2, active=1');
            $table->tinyInteger('rotate')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('buyers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_setups');
    }
}
