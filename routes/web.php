<?php

use App\Activity;
use App\Project;
use Illuminate\Support\Facades\Route;

//automatically listens to method created (after update, creating for before)
Project::created(function ($project)
{
    //After created generate project_id on Activity
    Activity::create([
        'project_id' => $project->activity
    ]);
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/projects', 'ProjectsController@index');
    Route::get('/projects/create', 'ProjectsController@create');
    Route::get('/projects/{project}', 'ProjectsController@show');
    Route::get('/projects/{project}/edit', 'ProjectsController@edit');
    Route::post('/projects', 'ProjectsController@store');
    //listen to @method('patch')
    Route::patch('/projects/{project}', 'ProjectsController@update');

    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');

    //listen to @method('patch')
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();

