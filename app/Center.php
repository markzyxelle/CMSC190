<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id', 'center_code', 'name',
    ];

    /**
     * Get the groups under this center.
     */
    public function groups()
    {
        return $this->hasMany('App\Group');
    }
}
