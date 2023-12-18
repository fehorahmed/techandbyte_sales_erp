<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\SubCategoryFactory::new();
    }
}
