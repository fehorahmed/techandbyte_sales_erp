<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\InventoryOrderDetailFactory;
use Modules\Product\Entities\Product;

class InventoryOrderDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['product_inventory_id'];

    public function product() {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    protected static function newFactory(): InventoryOrderDetailFactory
    {
        //return InventoryOrderDetailFactory::new();
    }
}
