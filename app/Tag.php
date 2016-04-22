<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the clients for the tags.
     */
    public function clients()
    {
        return $this->belongsToMany('App\Client', 'client_tags')->withPivot("id");
    }
}
