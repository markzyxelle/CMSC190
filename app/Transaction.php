<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loan_id', 'principal_amount', 'interest_amount', 'payment_date', 'due_date', 'cutoff_date',
    ];
}
