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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->string('date')->nullable();
            $table->double('base_amount',20,2)->default(0.00);
            $table->double('total_amount',20,2)->default(0.00);
            $table->double('paid_amount',20,2)->default(0.00);
            $table->double('due_amount',20,2)->default(0.00);
            $table->double('prevous_due',20,2)->default(0.00);
            $table->double('shipping_cost',20,2)->default(0.00);
            $table->bigInteger('invoice')->nullable();
            $table->bigInteger('offline_invoice_no')->nullable();
            $table->double('invoice_discount',20,2)->default(0.00)->comment('invoice discount');
            $table->double('total_discount',20,2)->default(0.00)->comment('total invoice discount');
            $table->double('total_vat_amnt',20,2)->default(0.00)->comment('total invoice vat');
            $table->double('total_tax',20,2)->default(0.00);
            $table->double('ret_adjust_amnt',20,2)->nullable();
            $table->double('returnable_amount',20,2)->nullable();
            $table->string('sales_by')->nullable();
            $table->text('delivery_note')->nullable();
            $table->text('invoice_details')->nullable();
            $table->tinyInteger('is_credit')->nullable();
            $table->integer('is_fixed')->nullable();
            $table->integer('is_dynamic')->nullable();
            $table->integer('status')->nullable();
            $table->string('bank_id')->nullable();
            $table->integer('payment_type')->nullable();
            $table->integer('is_online')->default(1);
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
        Schema::dropIfExists('invoices');
    }
};
