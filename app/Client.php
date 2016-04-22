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
        'barangay_id', 'group_id', 'status_id', 'gender_id', 'civil_status_id', 'beneficiary_type_id', 'birthplace', 'personal_id', 'national_id', 'uploaded_id', 'first_name', 'middle_name', 'last_name', 'suffix', 'mother_middle_name', 'birthdate', 'house_address', 'mobile_number', 'isDummy', 'cutoff_date',
    ];

    /**
     * Get the group that the client is under.
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    /**
     * Get the loans under this client.
     */
    public function loans()
    {
        return $this->hasMany('App\Loan');
    }

    /**
     * Get the tags for the client.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'client_tags')->withPivot("id");
    }
}
