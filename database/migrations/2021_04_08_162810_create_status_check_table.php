<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_check', function (Blueprint $table) {
            $table->id();
            $table->uuid('correlationId')->index();
            $table->uuid('lead_id');
            $table->char('status', 255);
            $table->integer('percentage')->nullable();
            $table->text('resp')->nullable();
            $table->json('data')->nullable();
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
        Schema::dropIfExists('status_check');
    }
}
