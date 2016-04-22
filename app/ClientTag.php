<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientTag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'tag_id',
    ];
}
