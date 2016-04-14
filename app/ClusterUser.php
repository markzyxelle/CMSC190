<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClusterUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cluster_id', 'user_id', 'isApproved',
    ];
}
