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
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('chalan_no')->nullable();
            $table->string('lc_no')->nullable();
            $table->bigInteger('supplier_id');
            $table->double('grand_total_amount',20,2);
            $table->double('paid_amount',20,2);
            $table->double('due_amount',20,2);
            $table->double('total_discount',20,2)->nullable();
            $table->double('invoice_discount',20,2)->comment('sum of product discount');
            $table->double('total_vat_amount',20,2)->comment('sum of product vat');
            $table->string('purchase_date')->nullable();
            $table->string('purchase_details')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('payment_type');
            $table->tinyInteger('is_credit')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('product_purchases');
    }
};
