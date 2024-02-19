<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\InventoryOrderFactory;
use Modules\Supplier\Entities\Supplier;

class InventoryOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function products() {
        return $this->hasMany(InventoryOrderDetail::class,'inventory_order_id');
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
    public function sum_quantity(){
        return $this->hasMany(InventoryOrderDetail::class)->sum('quantity');
    }
    protected static function newFactory(): InventoryOrderFactory
    {
        //return InventoryOrderFactory::new();
    }
}
