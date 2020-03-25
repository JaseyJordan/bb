<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\User;

class InvitationsTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function a_project_can_invite_a_user(){

        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        // user can add tasks, notes and complete tasks
        $this->signIn($newUser);

        //gets primary key dynamically
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo Task']);

        $this->assertDatabaseHas('tasks', $task);
   }



}
