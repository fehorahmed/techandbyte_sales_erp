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
        Schema::create('acc_opening_balances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fyear');
            $table->bigInteger('COAID');
            $table->bigInteger('subType')->default(1);
            $table->bigInteger('subCode')->nullable();
            $table->decimal('Debit',20,2)->nullable();
            $table->decimal('Credit',20,2)->nullable();
            $table->date('openDate');
            $table->integer('CreateBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_opening_balances');
    }
};
