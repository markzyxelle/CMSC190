<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'center_id', 'group_code', 'name',
    ];

    /**
     * Get the clients under this group.
     */
    public function clients()
    {
        return $this->hasMany('App\Client');
    }

    /**
     * Get the center that the group is under.
     */
    public function center()
    {
        return $this->belongsTo('App\Center');
    }
}
