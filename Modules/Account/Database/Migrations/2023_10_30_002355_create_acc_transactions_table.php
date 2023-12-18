<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vid');
            $table->bigInteger('fyear');
            $table->string('VNo')->nullable();
            $table->string('Vtype')->nullable();
            $table->string('referenceNo')->nullable();
            $table->date('VDate')->nullable();
            $table->string('COAID');
            $table->text('Narration')->nullable();
            $table->string('chequeNo')->nullable();
            $table->date('chequeDate')->nullable();
            $table->integer('isHonour')->nullable();
            $table->string('ledgerComment')->nullable();
            $table->decimal('Debit',20,2)->default(0.00);
            $table->decimal('Credit',20,2)->default(0.00);
            $table->integer('StoreID')->default(0);
            $table->char('IsPosted')->nullable();
            $table->integer('is_opening')->default(0);
            $table->bigInteger('CreateBy')->nullable();
            $table->bigInteger('UpdateBy')->nullable();
            $table->char('IsAppoved')->nullable();
            $table->bigInteger('RevCodde');
            $table->bigInteger('subType')->default(1);
            $table->bigInteger('subCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_transactions');
    }
};
