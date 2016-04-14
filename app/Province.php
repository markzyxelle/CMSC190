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
}
