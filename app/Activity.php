<?php

namespace App;
use App\User;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
