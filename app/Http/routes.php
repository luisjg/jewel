<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

// all API data routes are prefixed with /api
Route::group(['prefix' => 'api'], function() {

	// academic department information
	Route::get('departments/{dept_id}/people', 'DepartmentController@showPeople');
	Route::resource('departments', 'DepartmentController');

	// TODO: committee information
	//Route::get('committees/{committee_id}/people', 'CommitteeController@showPeople');
	//Route::resource('committees/{committee_id}', 'CommitteeController');

});