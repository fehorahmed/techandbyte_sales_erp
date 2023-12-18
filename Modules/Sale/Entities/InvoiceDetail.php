<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function product() {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    protected static function newFactory()
    {
        return \Modules\Sale\Database\factories\InvoiceDetailFactory::new();
    }
}
