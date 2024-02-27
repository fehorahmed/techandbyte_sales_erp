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
        Schema::create('sale_vats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->float('amount',8,2);
            $table->unsignedTinyInteger('status')->comment('0=Initial, 1=Paid');
            $table->foreign('invoice_id')->on('invoices')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_vats');
    }
};
