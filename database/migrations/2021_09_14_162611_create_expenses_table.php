<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {

            $table->id();
            $table->string('lead_id')->nullable();
            $table->integer('monthlyMortgageRent')->nullable();
            $table->integer('creditExpense')->nullable();
            $table->integer('otherExpense')->nullable();
            $table->integer('foodExpense')->nullable();
            $table->integer('transportExpense')->nullable();
            $table->integer('utilitiesExpense')->nullable();
            $table->integer('childCareExpense')->nullable();
            $table->integer('insuranceExpense')->nullable();
            $table->integer('alcoholTobaccoExpense')->nullable();
            $table->integer('healthBeautyExpense')->nullable();
            $table->integer('recreationExpense')->nullable();
            $table->integer('restaurantsExpense')->nullable();
            $table->integer('educationExpense')->nullable();
            $table->integer('clothingFootwearExpense')->nullable();
            $table->integer('householdGoodsExpense')->nullable();
            $table->integer('communicationEntertainmentExpense')->nullable();
            $table->integer('councilTaxExpense')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}

/*
 * here
 */