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

    protected $fillable = ['name'];

    protected $searchable = ['name'];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function loanHolder()
    {
        return $this->belongsTo(LoanHolder::class, 'loan_holder_id','id');
    }
    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class, 'loan_id', 'id');
    }

    public function loan_holders() {
        return $this->hasMany(LoanHolder::class, 'id','loan_holder_id');
    }

    protected static function newFactory(): LoanFactory
    {
        //return LoanFactory::new();
    }
}
