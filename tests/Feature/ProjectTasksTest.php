<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();
        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        //get project
        $project = factory('App\Project')->create();

        //if posting to project and not owner redirect to forbidden
        $this->post($project->path() . '/tasks', [ 'body' => 'Test Task' ])
        ->assertStatus(403);

        //make sure no new record in tasks table - second precaution
        $this->assertDatabaseMissing('tasks', ['body' => 'Test Task']);

    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_tasks()
    {

        $this->signIn();

        $project= ProjectFactory::withTasks(1)->create();

        //if posting to task and not owner redirect to forbidden
        $this->patch($project->tasks[0]->path(), [ 'body' => 'changed' ])
            ->assertStatus(403);

        //make sure no record changes in tasks table - second precaution
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);

    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project= ProjectFactory::create();

        //if you make post request to tasks url. add to body
        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', [ 'body' => 'Test Task' ]);

        //if task posted see task
        $this->get($project->path())
            ->assertSee('Test Task');

    }

    /** @test */
    public function a_task_can_be_updated()
    {
        //$this->withoutExceptionHandling();

        //create project with 1 task
        $project= ProjectFactory::withTasks(1)->create();

        //Try to get it from outside in
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed'
            ]);

        // check database for records
        $this->assertDatabaseHas('tasks', [
              'body' => 'changed'
            ]);

    }

    /** @test */
    public function a_task_can_be_completed()
    {
        //create project with 1 task
        $project= ProjectFactory::withTasks(1)->create();

        //check that it has been toggled
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        // check database for records
        $this->assertDatabaseHas('tasks', [
              'body' => 'changed',
              'completed' => true
            ]);

    }

     /** @test */
    public function a_task_can_be_marked_incomplete()
    {
        $this->withoutExceptionHandling();

        //create project with 1 task
        $project= ProjectFactory::withTasks(1)->create();

        //check that it has been toggled
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        //toggle the reverse
        $this->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => false
            ]);


        // check database for records
        $this->assertDatabaseHas('tasks', [
              'body' => 'changed',
              'completed' => false
            ]);

    }

    /** @test */
    public function a_task_requires_a_body()
    {

        $project= ProjectFactory::create();

        $attributes = factory('App\Task')->raw(['body'=>'']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');

    }


}
