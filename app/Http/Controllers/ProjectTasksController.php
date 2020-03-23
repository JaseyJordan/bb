<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        //validate
        $this->authorize('update', $project);

        request()->validate(['body' => 'required']);

        // if project add task to body
        $project->addTask(request('body'));

        return redirect($project->path());

    }

    public function update(Project $project, Task $task)
    {
        //validate - policy
        $this->authorize('update', $task->project);

        request()->validate(['body' => 'required']);

        $task->update([
            'body' => request('body'),
            //only sent through request if checked so ask if it has the request or set false
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());
    }

}
