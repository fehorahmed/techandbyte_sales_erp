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
        Schema::create('inventory_order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_purchase_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->decimal('quantity',20,2)->nullable();
            $table->decimal('rate',20,2)->default(0.00)->nullable();
            $table->decimal('selling_rate',20,2)->default(0.00)->nullable();
            $table->string('batch_id')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('total_amount',20,2)->default(0.00)->nullable();
            $table->float('discount_percent',20,2)->nullable();
            $table->decimal('discount_amount',20,2)->default(0.00);
            $table->decimal('vat_amount_percent',20,2)->default(0.00);
            $table->decimal('vat_amount',20,2)->default(0.00);
            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_order_details');
    }
};
