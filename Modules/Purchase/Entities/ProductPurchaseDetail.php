<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class ProductPurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_purchase_id'];

    public function product() {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    protected static function newFactory()
    {
        return \Modules\Purchase\Database\factories\ProductPurchaseDetailFactory::new();
    }
}
