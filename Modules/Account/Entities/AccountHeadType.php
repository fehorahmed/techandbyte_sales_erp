<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Account\Database\factories\AccountHeadTypeFactory;

class AccountHeadType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): AccountHeadTypeFactory
    {
        //return AccountHeadTypeFactory::new();
    }
}
