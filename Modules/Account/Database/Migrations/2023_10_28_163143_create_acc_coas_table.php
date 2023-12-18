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
        Schema::create('acc_coas', function (Blueprint $table) {
            $table->id();
            $table->integer('HeadCode');
            $table->string('HeadName');
            $table->string('PHeadName');
            $table->string('PHeadCode')->nullable();
            $table->string('HeadLevel');
            $table->tinyInteger('IsActive');
            $table->tinyInteger('IsTransaction');
            $table->tinyInteger('IsGL');
            $table->tinyInteger('isCashNature')->default(0);
            $table->tinyInteger('isBankNature')->default(0);
            $table->char('HeadType');
            $table->tinyInteger('IsBudget');
            $table->tinyInteger('IsDepreciation');
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->bigInteger('service_id')->nullable();
            $table->decimal('DepreciationRate',18,2);
            $table->string('CreateBy');
            $table->string('UpdateBy');
            $table->integer('isSubType')->default(0);
            $table->integer('subType')->default(1);
            $table->integer('isStock')->default(0);
            $table->integer('isFixedAssetSch')->default(0);
            $table->string('noteNo')->nullable();
            $table->string('assetCode')->nullable();
            $table->string('depCode')->nullable();
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
        Schema::dropIfExists('acc_coas');
    }
};
