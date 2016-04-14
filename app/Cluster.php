<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cluster_code', 'setting',
    ];

    /**
     * The users that belong to the cluster.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'cluster_users')->withPivot("id", "isApproved");
    }

    /**
     * Get the clients for the cluster.
     */
    public function clients()
    {
        return $this->belongsToMany('App\Client', 'client_clusters')->withPivot("id", "branch_id");
    }
}
