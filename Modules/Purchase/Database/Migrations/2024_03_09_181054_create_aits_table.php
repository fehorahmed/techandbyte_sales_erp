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
        Schema::create('aits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id');
            $table->foreignId('inventory_order_id');
            $table->float('amount',8,2);
            $table->string('date')->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('ait_document')->nullable();
            $table->unsignedTinyInteger('status')->comment('0=Initial, 1=Paid');
            $table->foreign('inventory_order_id')->on('inventory_orders')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aits');
    }
};
