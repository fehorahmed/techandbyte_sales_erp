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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['give', 'take']);
            $table->integer('loan_holder_id');
            $table->date('date');
            $table->unsignedTinyInteger('transaction_type')->comment('1=cash,2=bank');
            $table->unsignedFloat('amount', 8, 2);
            $table->string('details')->nullable();
            $table->foreignId('created_by');
            $table->foreign('created_by')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
