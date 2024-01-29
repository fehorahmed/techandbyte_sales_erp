<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_purchase_id');
            $table->string('chalan_no')->nullable();
            $table->string('lc_no')->unique()->nullable();
            $table->string('Batch_no')->unique()->nullable();
            $table->bigInteger('supplier_id');

            $table->float('duty',8,2);
            $table->float('freight',8,2);
            $table->float('c_and_f',8,2);
            $table->float('ait',8,2);
            $table->float('at',8,2);
            $table->float('etc',8,2);

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

            $table->foreign('product_purchase_id')->on('product_purchases')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_orders');
    }
};
