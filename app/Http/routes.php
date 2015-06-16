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
	// Example: /api/departments/189/people
	Route::get('departments/{dept_id}/people', 'DepartmentController@showPeople');

	// committee information
	// Example: /api/committees/atc/people
	Route::get('committees/{committee_id}/people', 'CommitteeController@showPeople');

});