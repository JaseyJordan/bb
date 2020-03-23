<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Project;
use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence(4),
        //set project id equal to new record in database and with this id
        'project_id' => factory(Project::class),
        'completed' => false
    ];
});
