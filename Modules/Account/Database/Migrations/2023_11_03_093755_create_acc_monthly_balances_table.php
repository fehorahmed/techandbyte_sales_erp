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
        Schema::create('acc_monthly_balances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fyear');
            $table->bigInteger('COAID');
            $table->decimal('balance1',20,2)->default(0.00);
            $table->decimal('balance2',20,2)->default(0.00);
            $table->decimal('balance3',20,2)->default(0.00);
            $table->decimal('balance4',20,2)->default(0.00);
            $table->decimal('balance5',20,2)->default(0.00);
            $table->decimal('balance6',20,2)->default(0.00);
            $table->decimal('balance7',20,2)->default(0.00);
            $table->decimal('balance8',20,2)->default(0.00);
            $table->decimal('balance9',20,2)->default(0.00);
            $table->decimal('balance10',20,2)->default(0.00);
            $table->decimal('balance11',20,2)->default(0.00);
            $table->decimal('balance12',20,2)->default(0.00);
            $table->decimal('totalBalance',20,2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_monthly_balances');
    }
};
