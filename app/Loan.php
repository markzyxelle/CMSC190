<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'loan_type_id', 'uploaded_id', 'loan_cycle', 'released_date', 'principal_amount', 'interest_amount', 'principal_balance', 'interest_balance', 'isActive', 'isReleased', 'status', 'maturity_date', 'cutoff_date', 
    ];

    /**
     * Get the transactions under this loan.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
