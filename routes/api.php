<?php

/*
|--------------------------------------------------------------------------
| Application API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


// academic department information
// Example: /api/departments/189/people
$router->get('departments/{dept_id}/people', 'DepartmentController@showPeople');

// committee information
// Example: /api/committees/atc/people
$router->get('committees/{committee_id}/people', 'CommitteeController@showPeople');

// center information
// Example: /api/centers/viscom/people
$router->get('centers/{center_id}/people', 'CenterController@showPeople');

// institutes information
// Example: /api/institutes/ichwb/people
$router->get('institutes/{institute_id}/people', 'InstituteController@showPeople');

// $router->get('institutes/{institute_id}/test', 'InstituteController@showPeopleTest');

// temporary route to test accordion functionality
$router->get('accordion', 'AccordionController@showData');