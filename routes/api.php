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
//Route::prefix('project')->group(function() {
    Route::get('/','ProjectController@index');
    Route::get('/{project}', 'ProjectController@get');
    Route::post('/', 'ProjectController@create');
    Route::put('/{project}', 'ProjectController@update');
    Route::delete('/{project}', 'ProjectController@delete');
});

