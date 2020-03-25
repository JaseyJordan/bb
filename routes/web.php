<?php

use Illuminate\Support\Facades\Route;

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
    return view('/auth/login');
});

Route::group(['middleware' => 'auth'], function()
{
    // finds routes from controller - php artisan route:list
    Route::resource('projects', 'ProjectsController');


    //listen to @method('patch')
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update');
    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();

