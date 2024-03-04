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
        Schema::create('product_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_purchase_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->decimal('quantity',20,2)->nullable();
            $table->decimal('rate',20,2)->default(0.00)->nullable();
            $table->string('batch_id')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('total_amount',20,2)->default(0.00)->nullable();
            $table->decimal('per_pcs_cost',50,3)->default(0.00)->nullable();
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_purchase_details');
    }
};
