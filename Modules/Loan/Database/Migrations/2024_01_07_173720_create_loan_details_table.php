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
        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id');
            $table->date('date');
            $table->unsignedFloat('amount', 8, 2);
            $table->unsignedTinyInteger('transaction_type')->comment('1=cash,2=bank');
            $table->foreignId('created_by');
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('loan_id')->on('loans')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_details');
    }
};
