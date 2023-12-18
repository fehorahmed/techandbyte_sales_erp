<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Supplier\Entities\Supplier;

class SupplierProduct extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }


    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\SupplierProductFactory::new();
    }
}
