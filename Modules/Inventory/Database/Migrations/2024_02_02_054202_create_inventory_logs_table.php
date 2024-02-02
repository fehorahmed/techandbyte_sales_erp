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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id');
            $table->foreignId('order_id')->comment('Inventory oder id or Sale order id');
            $table->enum('type', ['stock_in', 'stock_out']);
            $table->string('remark')->nullable()->comment('type of order/Invoice no');
            $table->foreign('inventory_id')->on('inventories')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
