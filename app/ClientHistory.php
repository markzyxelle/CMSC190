<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'status_id', 'date',
    ];

    
}
