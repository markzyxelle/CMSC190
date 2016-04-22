<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'role_id',
    ];

    /**
     * Get the users that has this company role.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * The activities that belong to the Company Role.
     */
    public function activities()
    {
        return $this->belongsToMany('App\Activity', 'company_role_activities', 'company_role_id', 'activity_id');
    }
}
