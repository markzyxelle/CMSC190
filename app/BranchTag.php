<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchTag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id', 'tag_id',
    ];
}
