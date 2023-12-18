<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccVoucher extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'acc_vouchers';

    public function account(){
        return $this->belongsTo(AccCoa::class,'COAID','HeadCode');
    }
    public function rev_account(){
        return $this->belongsTo(AccCoa::class,'RevCodde','HeadCode');
    }
    public function sub_account(){
        return $this->belongsTo(AccSubcode::class,'subCode','id');
    }

    public function details() {
        return $this->hasMany(AccVoucher::class,'VNo', 'VNo');
    }


    protected static function newFactory()
    {
        return \Modules\Account\Database\factories\AccVoucherFactory::new();
    }
}
