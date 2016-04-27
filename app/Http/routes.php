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
    Route::get('/switchDummyMode', 'GeneralController@switchDummyMode')->middleware(['unapproved', 'auth', 'normaluser']);        //toggles dummy mode
    Route::get('/structure', 'GeneralController@getStructure')->middleware(['unapproved', 'auth', 'normaluser']);   //show structure of microfinance institution   *
    Route::get('/getCenters/{branch}', 'GeneralController@getCenters')->middleware(['unapproved', 'auth', 'normaluser']);     //GET 
    Route::post('/addCenter', 'GeneralController@addCenter')->middleware(['unapproved', 'auth', 'normaluser']);     //add a center
    Route::get('/getGroups/{center}', 'GeneralController@getGroups')->middleware(['unapproved', 'auth', 'normaluser']);     //GET
    Route::post('/addGroup', 'GeneralController@addGroup')->middleware(['unapproved', 'auth', 'normaluser']);     //add a group
    Route::get('/getClients/{group}', 'GeneralController@getClients')->middleware(['unapproved', 'auth', 'normaluser']);     //GET
    Route::post('/addClient', 'GeneralController@addClient')->middleware(['unapproved', 'auth', 'normaluser']);     //add a client
    Route::get('/getProvinces/{region}', 'GeneralController@getProvinces')->middleware(['unapproved', 'auth', 'normaluser']);     //GET
    Route::get('/getMunicipalities/{province}', 'GeneralController@getMunicipalities')->middleware(['unapproved', 'auth', 'normaluser']);     //GET
    Route::get('/getBarangays/{municipality}', 'GeneralController@getBarangays')->middleware(['unapproved', 'auth', 'normaluser']);     //GET
    Route::get('/upload', 'GeneralController@getUpload')->middleware(['unapproved', 'auth', 'normaluser']);        //get upload page      *
    Route::post('/clientsCSV', 'GeneralController@clientsCSV')->middleware(['unapproved', 'auth', 'normaluser']);      //upload CSV for clients
    Route::post('/approveClientsCSV', 'GeneralController@approveClientsCSV')->middleware(['unapproved', 'auth', 'normaluser']);      //approve CSV for clients
    Route::post('/loansCSV', 'GeneralController@loansCSV')->middleware(['unapproved', 'auth', 'normaluser']);      //upload CSV for loans
    Route::post('/approveLoansCSV', 'GeneralController@approveLoansCSV')->middleware(['unapproved', 'auth', 'normaluser']);      //approve CSV for loans
    Route::get('/viewClient/{client}', 'GeneralController@viewClient')->middleware(['unapproved', 'auth', 'normaluser']);      //show page of client
    Route::post('/editClient/{client}', 'GeneralController@editClient')->middleware(['unapproved', 'auth', 'normaluser']);      //edit client
    Route::get('/getTransactions/{loan}', 'GeneralController@getTransactions')->middleware(['unapproved', 'auth', 'normaluser']);     //GET
    Route::post('/addLoan', 'GeneralController@addLoan')->middleware(['unapproved', 'auth', 'normaluser']);     //add a loan
    Route::post('/addTransaction', 'GeneralController@addTransaction')->middleware(['unapproved', 'auth', 'normaluser']);     //add a transaction
    Route::post('/addTag', 'GeneralController@addTag')->middleware(['unapproved', 'auth', 'normaluser']);     //add a tag
    Route::post('/deleteClient', 'GeneralController@deleteClient')->middleware(['unapproved', 'auth', 'normaluser']);     //delete a user
    Route::post('/deleteLoan', 'GeneralController@deleteLoan')->middleware(['unapproved', 'auth', 'normaluser']);     //delete a loan
    Route::post('/deleteTransaction', 'GeneralController@deleteTransaction')->middleware(['unapproved', 'auth', 'normaluser']);     //delete a transaction
    Route::post('/editLoan', 'GeneralController@editLoan')->middleware(['unapproved', 'auth', 'normaluser']);     //edit a loan
    Route::post('/editTransaction', 'GeneralController@editTransaction')->middleware(['unapproved', 'auth', 'normaluser']);     //edit a transaction
    Route::post('/deleteTag', 'GeneralController@deleteTag')->middleware(['unapproved', 'auth', 'normaluser']);     //delete a tag


    Route::get('/clusters', 'ClusterController@getCluster')->middleware(['unapproved', 'auth', 'normaluser']);        //get cluster page  *
    Route::post('/addCluster', 'ClusterController@addCluster')->middleware(['unapproved', 'auth', 'normaluser']);     //add a cluster
    Route::post('/joinCluster', 'ClusterController@joinCluster')->middleware(['unapproved', 'auth', 'normaluser']);     //join a cluster
    Route::get('/viewCluster/{cluster}', 'ClusterController@viewCluster')->middleware(['unapproved', 'auth', 'normaluser']);     //get the page for a specific cluster
    Route::get('/getClientsFromCenter/{center}/{tag}', 'ClusterController@getClientsFromCenter')->middleware(['unapproved', 'auth', 'normaluser']);     //get the clients that belong to a center
    Route::get('/getClientsFromGroup/{group}/{tag}', 'ClusterController@getClientsFromGroup')->middleware(['unapproved', 'auth', 'normaluser']);     //get the clients that belong to a group
    Route::get('/getClient/{client}/{tag}', 'ClusterController@getClient')->middleware(['unapproved', 'auth', 'normaluser']);     //get a single client
    Route::post('/addClientToCluster', 'ClusterController@addClientToCluster')->middleware(['unapproved', 'auth', 'normaluser']);     //add the client to a cluster
    Route::post('/removeClientFromCluster', 'ClusterController@removeClientFromCluster')->middleware(['unapproved', 'auth', 'normaluser']);     //remove the client from a cluster
    Route::get('/getActions/{clusteruser}', 'ClusterController@getActions')->middleware(['unapproved', 'auth', 'normaluser']);     //GET
    Route::post('/editClusterUser', 'ClusterController@editClusterUser')->middleware(['unapproved', 'auth', 'normaluser']);     //edit the user's available actions in the cluster
    Route::post('/deleteClusterUser/{clusteruser}', 'ClusterController@deleteClusterUser')->middleware(['unapproved', 'auth', 'normaluser']);     //delete the user from the cluster
    Route::post('/approveClusterUser', 'ClusterController@approveClusterUser')->middleware(['unapproved', 'auth', 'normaluser']);     //approve user's request to join cluster
    Route::post('/disapproveClusterUser/{clusteruser}', 'ClusterController@disapproveClusterUser')->middleware(['unapproved', 'auth', 'normaluser']);     //disapprove user's request to join cluster
    Route::post('/searchClientCluster', 'ClusterController@searchClientCluster')->middleware(['unapproved', 'auth', 'normaluser']);     //search user in cluster
    Route::post('/addUser', 'ClusterController@addUser')->middleware(['unapproved', 'auth', 'normaluser']);     //add user to cluster
    Route::post('/leaveCluster', 'ClusterController@leaveCluster')->middleware(['unapproved', 'auth', 'normaluser']);     //leave a cluster

    //administrator
    Route::get('/users', 'AdminController@users')->middleware(['unapproved', 'auth', 'administrator']);   //approved and pending users   *
    Route::get('/getApprovedUsers/{start}', 'AdminController@getApprovedUsers')->middleware(['unapproved', 'auth', 'administrator']);     //GET
    Route::get('/getPendingUsers/{start}', 'AdminController@getPendingUsers')->middleware(['unapproved', 'auth', 'administrator']);       //GET
    Route::get('/branches', 'AdminController@branches')->middleware(['unapproved', 'auth', 'administrator']);     //display branches   *
    Route::post('/addBranch', 'AdminController@addBranch')->middleware(['unapproved', 'auth', 'administrator']);      //add branch
    Route::post('/approveUser', 'AdminController@approveUser')->middleware(['unapproved', 'auth', 'administrator']);      //approve user    *
    Route::get('/roles', 'AdminController@roles')->middleware(['unapproved', 'auth', 'administrator']);     //display roles
    Route::post('/addRole', 'AdminController@addRole')->middleware(['unapproved', 'auth', 'administrator']);      //add role
    Route::post('/unapproveUser', 'AdminController@unapproveUser')->middleware(['unapproved', 'auth', 'administrator']);      //unapprove a user
    Route::post('/editBranch', 'AdminController@editBranch')->middleware(['unapproved', 'auth', 'administrator']);      //edit a branch
    Route::post('/editRole', 'AdminController@editRole')->middleware(['unapproved', 'auth', 'administrator']);      //edit a role
    Route::post('/editCompany', 'AdminController@editCompany')->middleware(['unapproved', 'auth', 'administrator']);      //edit a role

    //unapproved
    Route::get('/unapproved', 'HomeController@unapproved');
});
