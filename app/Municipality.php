<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    /**
     * Get the barangays under this municipality.
     */
    public function barangays()
    {
        return $this->hasMany('App\Barangay');
    }
}
