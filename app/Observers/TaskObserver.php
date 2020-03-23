<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->project->recordActivity('Task_created');
    }

    /**
     * Handle the project "deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $task->project->recordActivity('Task_deleted');
    }

}
