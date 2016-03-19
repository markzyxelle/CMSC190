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
     * Get the role name.
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }
}
