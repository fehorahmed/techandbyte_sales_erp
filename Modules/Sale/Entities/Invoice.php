<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Entities\Client;
use Modules\Customer\Entities\Customer;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function products()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Client::class, 'customer_id', 'id');
    }

    public function sum_quantity()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id')->sum('quantity');
    }
    protected static function newFactory()
    {
        return \Modules\Sale\Database\factories\InvoiceFactory::new();
    }
}
