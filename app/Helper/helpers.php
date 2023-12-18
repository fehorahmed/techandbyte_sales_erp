<?php

use Modules\Account\Entities\AccVoucher;
use Modules\Account\Entities\FinancialYear;

if (! function_exists('financial_year')) {
    function financial_year(){
        return FinancialYear::where('startDate','<=',date("Y-m-d"))->where("endDate",'>=',date("Y-m-d"))->where('status',1)->first()->id;
    }
}
if (! function_exists('voucherNo')) {
    function voucherNo($Vtype){
        $maxVoucher = AccVoucher::where('Vtype', $Vtype)->orderBy('id','desc')->first()->VNo??'';
        if($maxVoucher){
            $arr = explode('-',$maxVoucher);
            $voucherNo = $Vtype ."-". ( $arr[1]+1);
        }else{
            $voucherNo = $Vtype ."-1";
        }
        return $voucherNo;
    }
}
