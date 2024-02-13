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
        Schema::create('account_head_sub_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_head_type_id');
            $table->string('name');
            $table->boolean('status');
            $table->foreign('account_head_type_id')->on('account_head_types')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_head_sub_types');
    }
};
