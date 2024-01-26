<?php

namespace Modules\Task\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Task\Database\factories\TaskFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): TaskFactory
    {
        //return TaskFactory::new();
    }

    public function creator(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
