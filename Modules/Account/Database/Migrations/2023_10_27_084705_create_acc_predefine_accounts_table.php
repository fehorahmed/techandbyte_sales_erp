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
        Schema::create('acc_predefine_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('cashCode');
            $table->integer('bankCode');
            $table->integer('advance');
            $table->integer('fixedAsset');
            $table->integer('purchaseCode');
            $table->integer('salesCode');
            $table->integer('serviceCode');
            $table->integer('customerCode');
            $table->integer('supplierCode');
            $table->integer('costs_of_good_solds');
            $table->integer('vat');
            $table->integer('tax');
            $table->integer('inventoryCode');
            $table->integer('CPLCode');
            $table->integer('LPLCode');
            $table->integer('salary_code')->nullable();
            $table->integer('emp_npf_contribution')->nullable();
            $table->integer('empr_npf_contribution')->nullable();
            $table->integer('emp_icf_contribution')->nullable();
            $table->integer('empr_icf_contribution')->nullable();
            $table->integer('prov_state_tax');
            $table->integer('state_tax');
            $table->integer('prov_npfcode')->nullable();
            $table->timestamps();
        });


     // Insert predefined data into the table acc_predefine_accounts

        DB::table('acc_predefine_accounts')->insert([
            'cashCode' => 10201,
            'bankCode' => 10205,
            'advance' => 10206,
            'fixedAsset' => 101,
            'purchaseCode' => 1020401,
            'salesCode' => 3010301,
            'serviceCode' => 3010401,
            'customerCode' => 1020801,
            'supplierCode' => 5020201,
            'costs_of_good_solds' => 4010101,
            'vat' => 0,
            'tax' => 4021101,
            'inventoryCode' => 1020401,
            'CPLCode' => 2010201,
            'LPLCode' => 2010202,
            'salary_code' => 4020501,
            'emp_npf_contribution' => 4020502,
            'empr_npf_contribution' => 4020503,
            'emp_icf_contribution' => 4021201,
            'empr_icf_contribution' => 0,
            'prov_state_tax' => 5020101,
            'state_tax' => 4021101,
            'prov_npfcode' => 5020102,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),

        ]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_predefine_accounts');
    }
};
