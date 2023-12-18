<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccSubcode extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function accSubType(){
        return $this->belongsTo(AccSubtype::class,'subTypeId','id');
    }
    protected static function newFactory()
    {
        return \Modules\Account\Database\factories\AccSubcodeFactory::new();
    }
}
