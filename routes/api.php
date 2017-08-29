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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Projects
Route::middleware(['jsonapi', 'auth.firebase'])->prefix('project')->group(function() {
    Route::get('/','ProjectController@index');
    Route::get('/{project}', 'ProjectController@get');
    Route::post('/', 'ProjectController@create');
    Route::put('/{project}', 'ProjectController@update');
    Route::delete('/{project}', 'ProjectController@delete');
});

//Users
Route::middleware(['jsonapi', 'auth.firebase'])->prefix('user')->group(function() {
   Route::get('/', 'UserController@currentUser');
   Route::get('/{user}', 'UserController@get');
   Route::put('/', 'UserController@updateCurrentUser');
});

Route::middleware('jsonapi')->post('/user', 'UserController@create');

//Teams
Route::middleware(['jsonapi', 'auth.firebase'])->prefix('team')->group(function() {
    Route::get('/{team}', 'TeamController@get');
    Route::post('/', 'TeamController@create');
    Route::put('/{team}', 'TeamController@update');
    Route::delete('/{team}', 'TeamController@delete');
});