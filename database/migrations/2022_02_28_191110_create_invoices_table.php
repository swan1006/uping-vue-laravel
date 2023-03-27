<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            // TODO: refactor
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->unsignedBigInteger('buyer_setup_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('advertiser_id')->nullable();

            $table->unsignedBigInteger('company_id')->nullable();


            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('title');
            $table->string('client');
            $table->decimal('sub_total');
            $table->decimal('discount')->nullable();
            $table->decimal('balance');
            $table->integer('invoiceStatus');
            $table->decimal('paid_amount');
            $table->integer('currency');
            $table->timestamps();


            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');;
            $table->foreign('buyer_setup_id')->references('id')->on('buyer_setups')->onDelete('cascade');;
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');;
            $table->foreign('advertiser_id')->references('id')->on('advertisers')->onDelete('cascade');;
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');;



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
