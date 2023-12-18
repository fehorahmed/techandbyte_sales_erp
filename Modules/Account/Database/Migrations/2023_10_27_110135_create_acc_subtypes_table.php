<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Account\Entities\AccSubtype;
use Illuminate\Support\Facades\Auth;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_subtypes', function (Blueprint $table) {
            $table->id();
            $table->string('subtypeName');
            $table->tinyInteger('created_by');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
//        $data =  array(
//            [
//                'subtypeName' => 'None',
//                'created_by'  => 1,
//                'status'      => 1
//            ],
//            [
//                'subtypeName' => 'Employee',
//                'created_by'  => 1,
//                'status'      => 1
//            ],
//            [
//                'subtypeName' => 'Customer',
//                'created_by'  => 1,
//                'status'      => 1
//            ],
//            [
//                'subtypeName' => 'Supplier',
//                'created_by'  => 1,
//                'status'      => 1
//            ],
//            [
//                'subtypeName' => 'Agent',
//                'created_by'  => 1,
//                'status'      => 1
//            ],
//        );
//        foreach ($data as $datum){
//            $accSubType = new AccSubtype();
//            $accSubType->subtypeName =$datum['subtypeName'];
//            $accSubType->subtypeName =$datum['created_by'];
//            $accSubType->subtypeName =$datum['status'];
//            $accSubType->save();
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_subtypes');
    }
};
