<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

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
        $task = $this->tasks()->create(compact('body'));

        Activity::create([
           'project_id' => $this->id,
           'description' => 'Task_created'
        ]);

        return $task;

    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
