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

Route::get('/', function () {
    return Redirect::to("/home");
});

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
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    //normal user
    Route::get('/home', 'HomeController@index')->middleware(['unapproved']);		//home page

    //administrator

    Route::get('/users', 'AdminController@users')->middleware(['administrator']);	//approved and pending users
    Route::get('/getApprovedUsers/{start}', 'AdminController@getApprovedUsers')->middleware(['administrator']);		//GET
    Route::get('/getPendingUsers/{start}', 'AdminController@getPendingUsers')->middleware(['administrator']);		//GET
    Route::get('/branches', 'AdminController@branches')->middleware(['administrator']);		//display branches
    Route::post('/addBranch', 'AdminController@addBranch')->middleware(['administrator']);		//add branch

    //unapproved
    Route::get('/unapproved', 'HomeController@unapproved');
});
