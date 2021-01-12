<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/404', function () {
    return abort(404);
});

//LOGIN..
Route::post('login', 'LoginController@login')->name('login');
Route::get('login', 'LoginController@login')->name('login');
Route::get('login/recoveryAccess', 'LoginController@recoveryAccess');
Route::post('login/recoveryProcess', 'LoginController@recoveryProcess');
Route::get('login/recoverySuccess', 'LoginController@recoverySuccess');

//**Preloader*/
Route::get('login/authLoader', 'LoginController@authLoader');
Route::post('login/getAuthMenu', 'LoginController@getAuthMenu');


Route::get('logout', 'LoginController@logout');

Route::resource('/', 'MainController');

Route::get('main', function () {
    return view('esqueleton/header');
});

Route::get('newComplaint', 'MainController@newComplaint');
Route::get('newComplaintByPartner', 'MainController@newComplaintByPartner');


Route::get('complaintReport', 'MainController@complaintReport');
Route::get('complaintReportByPartner', 'MainController@complaintReportByPartner');
Route::get('complaintReportBySupervisor', 'ComplaintsController@complaintReportBySupervisor');
Route::get('complaintReportByManager', 'ComplaintsController@complaintReportByManager');
Route::get('complaintReportByManagerArea', 'ComplaintsController@complaintReportByManagerArea');


Route::get('complaints/complaintSuccess/id/{resourse}', 'MainController@complaintSuccess');
Route::get('complaints/complaintSolvedSuccess/id/{resourse}', 'ComplaintsController@complaintSolvedSuccess');
Route::get('complaints/complaintPDF/id/{resourse}','ComplaintsController@complaintPDF');
Route::get('complaints/createComplaintSolution/id/{resourse}', 'ComplaintsController@createComplaintSolution');

//suggestion
Route::get('suggestionReport', 'MainController@suggestionReport');
Route::get('newSuggestion', 'MainController@newSuggestion');

//congratulation
Route::get('congratulationReport', 'MainController@congratulationReport');
Route::get('newCongratulation', 'MainController@newCongratulation');


Route::get('profile', 'MainController@profile');



Route::get('profileByPartner', 'MainController@profileByPartner');

Route::get('password', function () {
    return view('profile/passwordForm');
});

Route::get('surveyJson', 'MainController@surveyJson');

Route::get('surveyReport', 'SurveyController@surveyReport');
Route::get('surveys/surveyPDF/id/{resourse}','SurveyController@surveyPDF');



Route::get('complaintPdf', function () {
    return view('pdfTemplates/complaintTemplate');
});

Route::get('newSurvey/complaint_id/{complaint}/partner_id/{partner}', 'SurveyController@newSurvey');
Route::post('surveys/createSurvey', 'SurveyController@createSurvey');

Route::get('surveys/surveySuccess', function () {
    return view('survey/surveySuccess');
});

Route::get('newSurveyByPartner', function () {
    return view('survey/newSurveyFormByPartner');
});


Route::get('stores', 'MainController@stores');
Route::get('storesByPartner', 'MainController@storesByPartner');
Route::get('storesBySupervisor', 'StoresController@storesBySupervisor');
Route::get('storesByManager', 'StoresController@storesByManager');


//supervisors
Route::get('supervisorsByManager', 'MainController@supervisorsByManager');

//dashboard
Route::get('dashboard', 'MainController@dashboard');
Route::get('dashboardByPartner', 'MainController@dashboardByPartner');
Route::get('dashboardBySupervisor', 'MainController@dashboardBySupervisor');
Route::get('dashboardByManager', 'MainController@dashboardByManager');
Route::get('dashboardByManagerArea', 'MainController@dashboardByManagerArea');


Route::get('customers', 'MainController@customers');


Route::get('reports', 'ReportsController@reports');
Route::post('reports/processorReport', 'ReportsController@processorReport');



Route::get('byType', function () {
    return view('reports/byTypeReport');
});

Route::get('users', 'MainController@users');
Route::get('users/validateUserEmail', 'UsersController@ajaxValidateUserEmail');

Route::get('newUser', 'MainController@newUser');


Route::get('complaintMail', function () {
    return view('email/complaintNotification');
});

Route::get('complaintSolve', function () {
    return view('email/complaintSolveNotification');
});

