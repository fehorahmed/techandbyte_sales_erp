<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Purchase\Database\factories\PurchasePaymentFactory;

class PurchasePayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): PurchasePaymentFactory
    {
        //return PurchasePaymentFactory::new();
    }
}
