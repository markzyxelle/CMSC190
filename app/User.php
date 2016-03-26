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
        'company_id', 'company_role_id','name', 'username', 'email', 'password', 'isApproved', 'branch_id', 'dummy_mode',
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
     * Get the role of the user in the company.
     */
    public function companyrole()
    {
        return $this->belongsTo('App\CompanyRole', 'company_role_id');
    }

    /**
     * Get the branch that the user works for.
     */
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
}
