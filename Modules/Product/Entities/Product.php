<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Supplier\Entities\Supplier;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class, 'id', 'product_id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }
}
