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
//Route::get('login', 'LoginController@login')->name('login');

Route::group(['prefix' => 'auth'], function () {
  //  Route::resource('/', 'MainController');


   // Route::post('signup', 'LoginController@signup');

    Route::group(['middleware' => 'auth:api'], function() {
       // Route::get('logout', 'LoginController@logout');
        Route::get('user', 'UsersController@user')->name('user');

    });
});

Route::group(['middleware' => 'auth:api'], function() {
    // Route::get('logout', 'LoginController@logout');
    //users
    Route::get('users/getUsers', 'ApiController@getUsers');
    Route::get('users/getSupervisorsByManager', 'ApiController@getSupervisorsByManager');

    Route::post('users/createUser', 'ApiController@createUser');
    Route::get('users/getUserById', 'ApiController@getUserById');
    Route::post('users/updateUserAccountById', 'ApiController@updateUserAccountById');
    Route::post('users/changeUserPasswordById', 'ApiController@changeUserPasswordById');
    Route::post('users/deleteUserById', 'ApiController@deleteUserById');

    //stores
    Route::get('stores/getStores', 'ApiController@getStores');
    Route::get('stores/storesByGroup', 'ApiController@storesByGroup');
    Route::get('stores/getStoresByPartner', 'ApiController@getStoresByPartner');
    Route::get('stores/getStoresBySupervisor', 'ApiController@getStoresBySupervisor');
    Route::get('stores/getStoresByManager', 'ApiController@getStoresByManager');
    //departments
    Route::get('departments/getDepartments', 'ApiController@getDepartments');

    //partners
    Route::get('partners/getPartners', 'ApiController@getPartners');
    Route::post('partners/getPartnerStores', 'ApiController@getPartnerStores');
    //complaints
    Route::get('complaints/getComplaints', 'ApiController@getComplaints');
    Route::get('complaints/getComplaintsByPartner', 'ApiController@getComplaintsByPartner');
    Route::get('complaints/getComplaintsBySupervisor', 'ApiController@getComplaintsBySupervisor');
    Route::get('complaints/getComplaintsByManager', 'ApiController@getComplaintsByManager');
    Route::get('complaints/getComplaintsByManagerArea', 'ApiController@getComplaintsByManagerArea');
    Route::get('complaints/getComplaintsPendingByManagerArea', 'ApiController@getComplaintsPendingByManagerArea');

    Route::get('complaints/getCategoryComplaint','ApiController@getCategoryComplaint');
    Route::get('complaints/getCategoryRequest','ApiController@getCategoryRequest');
    Route::get('complaints/getComplaintById','ApiController@getComplaintById');
    Route::post('complaints/createComplaint', 'ApiController@createComplaint');
    Route::post('complaints/createComplaintByPartner', 'ApiController@createComplaintByPartner');
    Route::post('complaints/solveComplaint', 'ApiController@solveComplaint');



    //suggestions
    Route::get('suggestions/getSuggestions', 'ApiController@getSuggestions');
    Route::post('suggestions/createSuggestion', 'ApiController@createSuggestion');
    Route::post('suggestions/createSuggestionByPartner', 'ApiController@createSuggestionByPartner');
    Route::get('suggestions/getSuggestionById','ApiController@getSuggestionById');


    //congratulations
    Route::get('congratulations/getCongratulations', 'ApiController@getCongratulations');
    Route::get('congratulations/getCongratulationById','ApiController@getCongratulationById');

    Route::post('congratulations/createCongratulation', 'ApiController@createCongratulation');
    Route::post('congratulations/createCongratulationByPartner', 'ApiController@createCongratulationByPartner');

    //surveys
    Route::get('surveys/getSurveys', 'ApiController@getSurveys');
    Route::get('surveys/getSurveyById', 'ApiController@getSurveyById');

    Route::get('customers/getCustomers', 'ApiController@getCustomers');

    Route::post('profile/changeUserPassword', 'ApiController@changeUserPassword');
    Route::post('profile/updateUserProfile', 'ApiController@updateUserProfile');





 });
