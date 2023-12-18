<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Entities\Customer;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function products() {
        return $this->hasMany(InvoiceDetail::class,'invoice_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }


    protected static function newFactory()
    {
        return \Modules\Sale\Database\factories\InvoiceFactory::new();
    }
}
