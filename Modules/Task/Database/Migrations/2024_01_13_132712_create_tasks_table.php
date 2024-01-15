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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id');
            $table->unsignedInteger('task_type')->comment('1=Individual, 2=Market visit');
            $table->date('date');
            $table->string('reason')->nullable();
            $table->string('remark')->nullable();
            $table->unsignedTinyInteger('status')->comment('1=Task Init, 2=Task Done');
            $table->foreignId('created_by');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('created_by')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
