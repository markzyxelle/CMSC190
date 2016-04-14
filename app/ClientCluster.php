<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCluster extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'cluster_id', 'branch_id',
    ];
}
