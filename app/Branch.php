<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'company_id',
    ];

    /**
     * Get the company that the branch is under.
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * Get the centers under this branch.
     */
    public function centers()
    {
        return $this->hasMany('App\Center');
    }
}
