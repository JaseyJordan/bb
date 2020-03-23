<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function creating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('Created', $project->activity[0]->description);
    }

    /** @test */

    public function updating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $project->update([ 'title' => 'Changed' ]);

        $this->assertCount(2, $project->activity);
        //check last description equals updated
        $this->assertEquals('Updated', $project->activity->last()->description);
    }

    /** @test */

    public function creating_a_new_task_records_project_activity()
    {

        $project = ProjectFactory::create();

        $project->addTask('Task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('Task_created', $project->activity->last()->description);

    }
}
