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
    Route::get('/switchDummyMode', 'GeneralController@switchDummyMode')->middleware(['auth', 'unapproved']);        //toggles dummy mode
    Route::get('/structure', 'GeneralController@getStructure')->middleware(['auth']);   //show structure of microfinance institution
    Route::get('/getCenters/{branch}', 'GeneralController@getCenters')->middleware(['auth']);     //GET
    Route::post('/addCenter', 'GeneralController@addCenter')->middleware(['auth']);     //add a center
    Route::get('/getGroups/{center}', 'GeneralController@getGroups')->middleware(['auth']);     //GET
    Route::post('/addGroup', 'GeneralController@addGroup')->middleware(['auth']);     //add a group
    Route::get('/getClients/{group}', 'GeneralController@getClients')->middleware(['auth']);     //GET
    Route::post('/addClient', 'GeneralController@addClient')->middleware(['auth']);     //add a group
    Route::get('/getProvinces/{region}', 'GeneralController@getProvinces')->middleware(['auth']);     //GET
    Route::get('/getMunicipalities/{province}', 'GeneralController@getMunicipalities')->middleware(['auth']);     //GET
    Route::get('/getBarangays/{municipality}', 'GeneralController@getBarangays')->middleware(['auth']);     //GET
    Route::get('/upload', 'GeneralController@getUpload')->middleware(['auth']);        //get upload page
    Route::post('/clientsCSV', 'GeneralController@clientsCSV')->middleware(['auth']);      //upload CSV for clients
    Route::post('/approveClientsCSV', 'GeneralController@approveClientsCSV')->middleware(['auth']);      //approve CSV for clients


    Route::get('/clusters', 'ClusterController@getCluster')->middleware(['auth']);        //get cluster page
    Route::post('/addCluster', 'ClusterController@addCluster')->middleware(['auth']);     //add a cluster
    Route::post('/joinCluster', 'ClusterController@joinCluster')->middleware(['auth']);     //join a cluster
    Route::get('/viewCluster/{cluster}', 'ClusterController@viewCluster')->middleware(['auth']);     //get the page for a specific cluster
    Route::get('/getClientsFromCenter/{center}', 'ClusterController@getClientsFromCenter')->middleware(['auth']);     //get the clients that belong to a center
    Route::get('/getClient/{client}', 'ClusterController@getClient')->middleware(['auth']);     //get a single client
    //getClientsFromGroup is getClients in general controller
    Route::post('/addClientToCluster', 'ClusterController@addClientToCluster')->middleware(['auth']);     //add the client to a cluster
    Route::post('/removeClientFromCluster', 'ClusterController@removeClientFromCluster')->middleware(['auth']);     //remove the client from a cluster

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
