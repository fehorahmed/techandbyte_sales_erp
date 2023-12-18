<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->bigInteger('ret_invoice_id')->nullable();
            $table->bigInteger('product_id');
            $table->string('serial_no')->nullable();
            $table->string('description')->nullable();
            $table->decimal('quantity',20,2)->nullable();
            $table->decimal('rate',20,2)->nullable();
            $table->string('batch_id')->nullable();
            $table->double('supplier_rate',20,2)->nullable();
            $table->decimal('total_price',20,2)->nullable();
            $table->decimal('discount',20,2)->nullable();
            $table->string('discount_per')->nullable();
            $table->decimal('vat_amnt',20,2)->nullable();
            $table->string('vat_amnt_per')->nullable();
            $table->decimal('tax',20,2)->nullable();
            $table->decimal('paid_amount',20,2)->nullable();
            $table->decimal('due_amount',20,2)->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('invoice_details');
    }
};
