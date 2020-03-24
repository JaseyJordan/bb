<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        //if user logged in is equal to project owner
        return $this->belongsTo(User::class);

    }

    public function tasks()
    {
        //if a project can have many tasks then
        return $this->hasMany(Task::class);

    }


    public function addTask($body)
    {

        //For the project tasks, create new one where body is equal to $body
        return $this->tasks()->create(compact('body'));

    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges($description)
        ]);

    }

    public function activityChanges($description)
    {
        if($description == 'updated'){
            return [
                'before' => Arr::except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at') //array_diff($this->getAttributes(), $this->old)
            ];
        }
    }
}
