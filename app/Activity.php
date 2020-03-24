<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //fixes error mass assignment
    protected $guarded = [];

    protected $casts = [
        'changes' => 'array'
    ];

    public function subject()
    {
        return $this->morphTo();
    }

}
