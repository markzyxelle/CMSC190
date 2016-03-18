<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'company_role_id','name', 'username', 'email', 'password', 'isApproved', 'branch_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the company that employs the user.
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * Get the company that employs the user.
     */
    public function companyrole()
    {
        return $this->belongsTo('App\CompanyRole', 'company_role_id');
    }
}
