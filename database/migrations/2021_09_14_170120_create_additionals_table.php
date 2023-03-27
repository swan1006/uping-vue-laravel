<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additionals', function (Blueprint $table) {
//            $table->uuid('id')->primary();
            $table->id();
            $table->string('lead_id')->nullable();

            $table->char('bestTimeToCall');
            $table->integer('creditScore');
            $table->integer('isCarOwner');
            $table->char('bankruptcy');
            $table->char('cosigner');
            $table->char('ref_first_name_1');
            $table->char('ref_last_name_1');
            $table->char('ref_phone_1');
            $table->char('ref_relation_1');
            $table->char('ref_first_name_2');
            $table->char('ref_last_name_2');
            $table->char('ref_phone_2');
            $table->char('ref_relation_2');
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
        Schema::dropIfExists('additionals');
    }
}
