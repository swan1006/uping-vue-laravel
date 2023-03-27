<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consents', function (Blueprint $table) {
//            $table->uuid('id')->primary();
            $table->id();
            $table->string('lead_id')->nullable();

            $table->boolean('consentFinancial')->nullable();
            $table->boolean('consentCreditSearch')->nullable();
            $table->boolean('consentThirdPartyEmails')->nullable();
            $table->boolean('consentThirdPartySMS')->nullable();
            $table->boolean('consentThirdPartyPhone')->nullable();
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
        Schema::dropIfExists('consents');
    }
}
