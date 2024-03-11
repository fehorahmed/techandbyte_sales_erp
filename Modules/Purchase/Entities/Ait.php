<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Entities\InventoryOrder;
use Modules\Purchase\Database\factories\AitFactory;
use Modules\Supplier\Entities\Supplier;

class Ait extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function invoice()
    {
        return $this->belongsTo(InventoryOrder::class, 'inventory_order_id', 'id');
    }

    protected static function newFactory(): AitFactory
    {
        //return AitFactory::new();
    }
}
