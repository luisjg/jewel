<?php namespace Jewel\Http\Controllers;

use Jewel\Http\Requests;
use Jewel\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Jewel\Department;
use Jewel\Person;
use Jewel\Http\Controllers\Response;


class DepartmentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		// NEED A EASY WAY TO PASS DATA TO URL

		$persons = Person::whereHas('department', function($query) {
			$query->where('department_id', 'academic_departments:189');
		})->get();

		// Build Department Listing
		$deptList = '';

		foreach ($persons as $person) {
			$deptList .= "<h3>{$person->common_name}</h3><ul><li><strong>Email: </strong><a href='mailto:{$person->email}'>{$person->email}</a></li><li><strong>Biography: </strong>{$person->biography}</li><li><a href='https://faculty-demo.sandbox.csun.edu/people/{$person->getEmailURIAttribute()}'>View Profile</a></li></ul>";
		}
		// return $deptList;
		
		return response()->json(['data' => $deptList]);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
