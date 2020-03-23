<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('Created', $project->activity[0]->description);
    }

    /** @test */

    public function updating_a_project()
    {
        $project = ProjectFactory::create();

        $project->update([ 'title' => 'Changed' ]);

        $this->assertCount(2, $project->activity);
        //check last description equals updated
        $this->assertEquals('Updated', $project->activity->last()->description);
    }

    /** @test */

    public function creating_a_task()
    {

        $project = ProjectFactory::create();

        $project->addTask('Task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('Task_created', $project->activity->last()->description);

    }

    /** @test */

    public function completing_a_task()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
            'body' => 'Foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('Task_completed', $project->activity->last()->description);

    }

    /** @test */

    public function incompleting_a_task()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'Foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'Foobar',
            'completed' => false
        ]);

        //fresh() copy from the database
        $project->refresh();

        $this->assertCount(4, $project->activity);

        $this->assertEquals('Task_incomplete', $project->activity->last()->description);

    }

    /** @test */
    public function delete_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);

    }

}
