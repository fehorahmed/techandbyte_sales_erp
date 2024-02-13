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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('transaction_type')->comment('1=Income; 2=Expense');
            $table->foreignId('account_head_type_id');
            $table->integer('receipt_no');
            $table->foreignId('account_head_sub_type_id');
            $table->tinyInteger('transaction_method')->comment('1=Cash; 2=Bank');
            $table->foreignId('bank_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->foreignId('bank_account_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('cheque_image')->nullable();
            $table->date('cheque_date')->nullable();
            $table->float('amount', 20,2);
            $table->date('date');
            $table->date('next_date')->nullable();
            $table->string('note')->nullable();

            $table->foreign('account_head_type_id')->on('account_head_types')->references('id');
            $table->foreignId('account_head_sub_type_id')->on('account_head_sub_types')->references('id');
            $table->foreign('bank_id')->on('banks')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
