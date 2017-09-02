<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Projects
Route::group(['middleware' => ['auth.firebase', 'jsonapi'], 'prefix' => 'project'], function () {
    Route::get('/', 'ProjectController@index');
    Route::get('/{project}', 'ProjectController@get');
    Route::post('/', 'ProjectController@create');
    Route::put('/{project}', 'ProjectController@update');
    Route::delete('/{project}', 'ProjectController@delete');
});

//Users
Route::group(['middleware' => ['auth.firebase', 'jsonapi'], 'prefix' => 'user'], function () {
    Route::get('/', 'UserController@currentUser');
    Route::get('/{user}', 'UserController@get');
    Route::put('/', 'UserController@updateCurrentUser');
});
Route::middleware('jsonapi')->post('/user', 'UserController@create');

//Teams
Route::group(['middleware' => ['auth.firebase', 'jsonapi'], 'prefix' => 'team'], function () {
    Route::get('/{team}', 'TeamController@get');
    Route::post('/', 'TeamController@create');
    Route::put('/{team}', 'TeamController@update');
    Route::delete('/{team}', 'TeamController@delete');
    Route::put('/{team}/adduser', 'TeamController@addUser');
});

//Tasks
Route::group(['middleware' => ['auth.firebase', 'jsonapi'], 'prefix' => 'task'], function () {
    Route::get('/', 'TaskController@index');
    Route::get('/{task}', 'TaskController@get');
    Route::post('/', 'TaskController@create');
    Route::put('/{task}/assign', 'TaskController@assign');
});

//Time
Route::group(['middleware' => ['auth.firebase', 'jsonapi'], 'prefix' => 'time'], function () {
    Route::get('/', 'TimelogController@index');
    Route::post('/checkin/{task}', 'TimelogController@checkin');
    Route::post('/checkout/{log}', 'TimelogController@checkout');
});
