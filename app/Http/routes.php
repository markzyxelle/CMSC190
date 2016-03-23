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
    Route::get('/users', 'AdminController@users')->middleware(['auth', 'administrator']);   //approved and pending users
    Route::get('/getApprovedUsers/{start}', 'AdminController@getApprovedUsers')->middleware(['auth', 'administrator']);     //GET
    Route::get('/getPendingUsers/{start}', 'AdminController@getPendingUsers')->middleware(['auth', 'administrator']);       //GET
    Route::get('/branches', 'AdminController@branches')->middleware(['auth', 'administrator']);     //display branches
    Route::post('/addBranch', 'AdminController@addBranch')->middleware(['auth', 'administrator']);      //add branch
    Route::post('/approveUser', 'AdminController@approveUser')->middleware(['auth', 'administrator']);      //approve user
    Route::get('/roles', 'AdminController@roles')->middleware(['auth', 'administrator']);     //display roles
    Route::post('/addRole', 'AdminController@addRole')->middleware(['auth', 'administrator']);      //add role

    //unapproved
    Route::get('/unapproved', 'HomeController@unapproved');
});
