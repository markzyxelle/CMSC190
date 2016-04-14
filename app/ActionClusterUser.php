<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionClusterUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action_id', 'cluster_user_id',
    ];

    /**
     * Get the actions for the Cluster User.
     */
    public function actions()
    {
        return $this->hasMany('App\Action');
    }
}
