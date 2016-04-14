<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'barangay_id', 'group_id', 'status_id', 'gender_id', 'civil_status_id', 'beneficiary_type_id', 'birthplace', 'personal_id', 'national_id', 'uploaded_id', 'first_name', 'middle_name', 'last_name', 'suffix', 'mother_middle_name', 'birthdate', 'house_address', 'mobile_number', 'isDummy',
    ];
}
