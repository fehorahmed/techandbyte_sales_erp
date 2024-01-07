<?php

namespace Modules\Loan\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Loan\Database\factories\LoanDetailFactory;

class LoanDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function newFactory(): LoanDetailFactory
    {
        //return LoanDetailFactory::new();
    }
}
