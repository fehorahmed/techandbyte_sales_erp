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
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('particular');
            $table->tinyInteger('transaction_type')->comment('1=Income; 2=Expense');
            $table->tinyInteger('transaction_method')->comment('1=Cash; 2=Bank');
            $table->foreignId('bank_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->foreignId('bank_account_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('cheque_image')->nullable();
            $table->float('amount', 20);
            $table->string('note')->nullable();
            $table->foreignId('transaction_id')->nullable();
            $table->foreignId('purchase_payment_id')->nullable();
            $table->foreignId('sale_payment_id')->nullable();

            $table->foreign('bank_id')->on('banks')->references('id');
            $table->foreign('transaction_id')->on('transactions')->references('id');
            $table->foreign('purchase_payment_id')->on('purchase_payments')->references('id');
            $table->foreign('sale_payment_id')->on('sale_payments')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
