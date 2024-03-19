<?php

namespace Modules\Purchase\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Bank\Entities\Bank;
use Modules\Supplier\Entities\Supplier;

class ProductPurchase extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function products()
    {
        return $this->hasMany(ProductPurchaseDetail::class, 'product_purchase_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    protected static function newFactory()
    {
        return \Modules\Purchase\Database\factories\ProductPurchaseFactory::new();
    }
}
