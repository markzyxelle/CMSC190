<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    /**
     * Get the provinces under this region.
     */
    public function provinces()
    {
        return $this->hasMany('App\Province');
    }
}
