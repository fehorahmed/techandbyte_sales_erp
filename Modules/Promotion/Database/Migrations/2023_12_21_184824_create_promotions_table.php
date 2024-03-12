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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->enum('promotion_type', ['Online', 'Offline']);
            $table->string('title');
            $table->string('platform');
            $table->unsignedInteger('cost');
            $table->date('date');
            $table->text('details')->nullable();

            $table->tinyInteger('transaction_method')->comment('1=Cash; 2=Bank');
            $table->foreignId('bank_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->foreignId('bank_account_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('cheque_image')->nullable();


            $table->foreignId('created_by');
            $table->foreignId('updated_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
            $table->foreign('bank_id')->on('banks')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
