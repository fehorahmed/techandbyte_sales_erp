<?php

namespace Modules\Promotion\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Promotion\Database\factories\PromotionFactory;

class Promotion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): PromotionFactory
    {
        //return PromotionFactory::new();
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
