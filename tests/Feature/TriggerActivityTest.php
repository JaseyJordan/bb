<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Task;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

    }

    /** @test */

    public function updating_a_project()
    {
        $project = ProjectFactory::create();

        $originalTitle = $project->title;

        $project->update([ 'title' => 'Changed' ]);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            //check last description equals updated
            $this->assertEquals('updated', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed']
            ];

            $this->assertEquals($expected, $activity->changes);

        });

    }

    /** @test */

    public function creating_a_task()
    {

        $project = ProjectFactory::create();

        $project->addTask('Task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity){
            $this->assertEquals('Task', $activity->subject->body);
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });


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

        tap($project->activity->last(), function ($activity){
             $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

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

        tap($project->activity->last(), function ($activity){
            $this->assertEquals('incomplete_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    /** @test */
    public function delete_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);

    }

}
