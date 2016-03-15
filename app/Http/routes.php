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
    Route::post('/round/{id}/{FK_team}/addPoints', ['uses' => 'RoundController@addPoints', 'as' => 'round.add_points']);

    Route::get('/auth/logout', ['uses' => 'AuthController@logout', 'as' => 'auth.logout']);
});

Route::group(['middleware' => ['web', 'quizmaster']], function () {
    Route::get('/admin', ['uses' => 'AdminController@index', 'as' => 'admin.index']);
    Route::post('/admin/api/users', ['uses' => 'AdminController@ajaxUsers', 'as' => 'admin.api_users']);
    Route::get('/admin/user/info/{id}', ['uses' => 'AdminController@userInfo', 'as' => 'admin.user_info']);
    Route::post('/admin/user/promote/{id}', ['uses' => 'AdminController@promoteUser', 'as' => 'admin.promote_user']);
    Route::post('/admin/user/demote/{id}', ['uses' => 'AdminController@demoteUser', 'as' => 'admin.demote_user']);
    Route::post('/admin/user/add', ['uses' => 'AdminController@AddUser', 'as' => 'admin.add_user']);
    Route::post('/admin/user/delete/{id}', ['uses' => 'AdminController@DeleteUser', 'as' => 'admin.delete_user']);
});