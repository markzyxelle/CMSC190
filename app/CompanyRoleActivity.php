<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyRoleActivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_role_id', 'activity_id',
    ];
}
