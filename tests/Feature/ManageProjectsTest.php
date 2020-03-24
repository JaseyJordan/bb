<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Support\Str;

class ManageProjectsTest extends TestCase
{

    use Withfaker, RefreshDatabase;

    /** @test */

    public function guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');

        $this->get('/projects/create')->assertRedirect('login');

        $this->get($project->path() . '/edit')->assertRedirect('login');

        $this->get($project->path())->assertRedirect('login');

        $this->post('/projects', $project->toArray())->assertRedirect('login'); // Access specific project

    }

    /** @test */

    public function a_user_can_create_a_project()
    {
        //disable error exception
        //$this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => $this->faker->paragraph
        ];

        //Try to create the project
        $response = $this->post('/projects', $attributes);
        //look for attributes if don't have id
        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */

    public function a_user_can_update_a_project()
    {
        //$this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['title' => 'changed', 'description' => 'changed', 'notes' => 'changed'])
            ->assertRedirect($project->path());

        //if get request to edit page assert is ok
        $this->get($project->path() . '/edit')->assertOk();

        //check database for changed record
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */

    public function a_user_can_update_a_projects_general_notes()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'changed']);

        //check database for changed record
        $this->assertDatabaseHas('projects', $attributes);

    }

    /** @test */

    public function a_user_can_view_their_project()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 100));
    }

    /** @test */

    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {

        $this->signIn();

        //$this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);

    }

    /** @test */

    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {

        $this->signIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path())->assertStatus(403);

    }

    /** @test */

    public function a_project_requires_a_title()
    {
        $this->signIn();
        //make stores object without writing to db // create stores object to db // raw stores as array
        $attributes = factory('App\Project')->raw(['title'=>'']);


        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */

    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description'=>'']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

}
