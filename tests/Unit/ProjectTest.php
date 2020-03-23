<?php

namespace Tests\Unit;

use Tests\Testcase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */

    public function it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);

    }

    /** @test */

    public function it_can_add_a_task()
    {
        $project = factory('App\Project')->create();

        $task = $project->addTask('Test Task');

        // does the project have 1 task
        $this->assertCount(1, $project->tasks);

        //check we're counting $project->addTask
        $this->assertTrue($project->tasks->contains($task));

    }

}
