<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    /**
     * Get the municipality that the barangay is under.
     */
    public function municipality()
    {
        return $this->belongsTo('App\Municipality');
    }
}
