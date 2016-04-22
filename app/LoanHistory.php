<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loan_id', 'status', 'date',
    ];
}
