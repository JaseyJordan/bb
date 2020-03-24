<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;

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
        return $this->tasks()->create(compact('body'));

    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

}
