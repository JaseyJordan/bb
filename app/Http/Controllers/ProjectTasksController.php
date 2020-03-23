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

        $task->update(request()->validate(['body' => 'required']));

        request('completed') ? $task->complete() : $task->incomplete();

        return redirect($project->path());
    }

}
