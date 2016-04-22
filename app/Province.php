<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    /**
     * Get the Municipalities under this province.
     */
    public function municipalities()
    {
        return $this->hasMany('App\Municipality');
    }

    /**
     * Get the region that the province is under.
     */
    public function region()
    {
        return $this->belongsTo('App\Region');
    }
}
