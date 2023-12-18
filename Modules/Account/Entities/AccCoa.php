<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccCoa extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function coaSubAccounts(){
        return $this->hasMany(AccCoa::class,'PHeadCode','HeadCode');
    }
    protected static function newFactory()
    {
        return \Modules\Account\Database\factories\AccCoaFactory::new();
    }
}
