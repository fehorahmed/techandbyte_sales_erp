<?php

namespace Modules\Supplier\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Entities\InventoryOrder;
use Modules\Purchase\Entities\PurchasePayment;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function getDueAttribute() {
        $supplier = Supplier::find($this->id);
        $total = InventoryOrder::where('supplier_id', $this->id)->sum('grand_total_amount');
        $paid = PurchasePayment::where('supplier_id', $this->id)->sum('amount');
        return $total - $paid + $supplier->opening_due;
    }

    public function getPaidAttribute() {
        return PurchasePayment::where('supplier_id', $this->id)->sum('amount');
    }

    public function getTotalAttribute() {
        return InventoryOrder::where('supplier_id', $this->id)->sum('grand_total_amount');
    }
    protected static function newFactory()
    {
        return \Modules\Supplier\Database\factories\SupplierFactory::new();
    }
}
