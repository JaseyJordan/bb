<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    //references any hasMany/belongsTo/be
    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created( function ($task) {

            $task->project->recordActivity('Task_created');

        });

    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function complete()
    {
        $this->update(['completed' => true]);

        $this->project->recordActivity('Task_completed');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->project->recordActivity('Task_incomplete');
    }





}
