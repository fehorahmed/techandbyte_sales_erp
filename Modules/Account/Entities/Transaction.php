<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Account\Database\factories\TransactionFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded =[];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): TransactionFactory
    {
        //return TransactionFactory::new();
    }

    public function headType() {
        return $this->belongsTo(AccountHeadType::class,'account_head_type_id','id');
    }

    public function subHeadType() {
        return $this->belongsTo(AccountHeadSubType::class,'account_head_sub_type_id','id');
    }
}
