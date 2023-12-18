<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Account\Database\factories\AccOpeningBalanceFactory;

class AccOpeningBalance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function account(){
        return $this->belongsTo(AccCoa::class,'COAID','HeadCode');
    }
    public function sub_account(){
        return $this->belongsTo(AccSubcode::class,'subCode','id');
    }

    protected static function newFactory(): AccOpeningBalanceFactory
    {
        //return AccOpeningBalanceFactory::new();
    }
}
