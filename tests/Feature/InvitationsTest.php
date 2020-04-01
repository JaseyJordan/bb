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
   public function non_owners_can_not_invite_users()
   {
       $project = ProjectFactory::create();

       $user = factory(User::class)->create();

       $assertInvitation = function() use ($user, $project){
            $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
        };

        $assertInvitation();

        $project->invite($user);

        $assertInvitation();
    }

   /** @test */
   public function a_project_owner_can_invite_users()
   {
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
   }

   /** @test */
   public function the_email_address_must_be_associated_with_a_valid_birdboard_account()
   {
        //$this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'Notauser@email.com'
                ])
            ->assertSessionHasErrors([
                'email' => 'The user you\'re inviting does not have a Birdboard account'
            ], null, 'invitations');
   }


   /** @test */
   public function invited_users_can_update_project_details()
   {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        // user can add tasks, notes and complete tasks
        $this->signIn($newUser);

        //gets primary key dynamically
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo Task']);

        $this->assertDatabaseHas('tasks', $task);
   }



}
