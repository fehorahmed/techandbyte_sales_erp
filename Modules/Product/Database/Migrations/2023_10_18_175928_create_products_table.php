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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->foreignId('category_id');
            $table->foreignId('brand_id');
            $table->foreignId('sub_category_id')->nullable();
            $table->foreignId('unit_id');
            $table->double('price', 20, 2)->default(0.00)->nullable();
            $table->string('serial_no')->nullable();
            $table->double('product_vat', 20, 2)->default(0.00)->nullable();
            $table->string('product_model')->nullable();
            $table->string('product_details')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->comment('1=Active, 0=Inactive');
            $table->foreign('unit_id')->on('units')->references('id');
            $table->foreign('category_id')->on('categories')->references('id');
            $table->foreign('sub_category_id')->on('sub_categories')->references('id');
            $table->foreign('brand_id')->on('brands')->references('id');
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
        Schema::dropIfExists('products');
    }
};
