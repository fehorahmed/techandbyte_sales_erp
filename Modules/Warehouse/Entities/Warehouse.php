<?php

namespace Modules\Warehouse\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Warehouse\Database\factories\WarehouseFactory;

class Warehouse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): WarehouseFactory
    {
        //return WarehouseFactory::new();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
