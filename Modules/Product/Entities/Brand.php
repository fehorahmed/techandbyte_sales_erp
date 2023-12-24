<?php

namespace Modules\Product\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\factories\BrandFactory;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): BrandFactory
    {
        //return BrandFactory::new();
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
