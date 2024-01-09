<?php

namespace Modules\Loan\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Loan\Database\factories\LoanFactory;

class Loan extends Model
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
    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class, 'loan_id', 'id');
    }

    protected static function newFactory(): LoanFactory
    {
        //return LoanFactory::new();
    }
}
