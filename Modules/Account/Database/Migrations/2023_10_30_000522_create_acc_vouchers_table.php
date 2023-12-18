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
        Schema::create('acc_vouchers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fyear');
            $table->string('VNo');
            $table->string('Vtype');
            $table->string('referenceNo')->nullable();
            $table->date('VDate');
            $table->bigInteger('COAID');
            $table->string('Narration')->nullable();
            $table->string('chequeno')->nullable();
            $table->date('chequeDate')->nullable();
            $table->integer('isHonour')->default(0);
            $table->string('ledgerComment')->nullable();
            $table->decimal('Debit',20,2)->default(0.00);
            $table->decimal('Credit',20,2)->default(0.00);
            $table->bigInteger('RevCodde');
            $table->bigInteger('subType')->default(1);
            $table->bigInteger('subCode')->nullable();
            $table->bigInteger('isApproved')->default(0);
            $table->bigInteger('CreateBy');
            $table->bigInteger('UpdateBy')->nullable();
            $table->bigInteger('approvedBy')->nullable();
            $table->tinyInteger('isyearClosed')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0 = non yet transfer to transation, 1 = Tranfer to transition');
            $table->dateTime('approved_at')->nullable();
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
        Schema::dropIfExists('acc_vouchers');
    }
};
