<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Entities\Client;
use Modules\Sale\Database\factories\SaleVatFactory;

class SaleVat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function customer()
    {
        return $this->belongsTo(Client::class, 'customer_id', 'id');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    protected static function newFactory(): SaleVatFactory
    {
        //return SaleVatFactory::new();
    }
}
