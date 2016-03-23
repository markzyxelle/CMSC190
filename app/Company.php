<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'shortname', 'company_code',
    ];

    /**
     * Get the users for the company.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function branches()
    {
        return $this->hasMany('App\Branch');
    }

    /**
     * Get the roles for the company.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'company_roles')->withPivot("id");
    }
}
