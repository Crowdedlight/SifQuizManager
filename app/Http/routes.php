<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
    Route::post('/auth/login', ['uses' => 'AuthController@login', 'as' => 'auth.login']);
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::post('/round/create', ['uses' => 'RoundController@create', 'as' => 'round.create']);

    Route::get('/round/', ['uses' => 'RoundController@index', 'as' => 'round.all']);

    Route::get('/round/{id}', ['uses' => 'RoundController@single', 'as' => 'round.single']);
    Route::post('/round/{id}/add', ['uses' => 'RoundController@addTeam', 'as' => 'round.add_team']);
    Route::post('/round/{id}/close', ['uses' => 'RoundController@close', 'as' => 'round.close']);

    Route::get('/auth/logout', ['uses' => 'AuthController@logout', 'as' => 'auth.logout']);
});