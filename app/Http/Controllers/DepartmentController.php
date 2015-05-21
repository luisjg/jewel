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
		$dept_id = \Request::get('department_id');

		// RETURN PEOPLE WHO HAVE DEPARTMENT
		$persons = Person::whereHas('departmentUser', function($q) use ($dept_id) {
			$q->where('department_id', 'academic_departments:'.$dept_id);
		})
		// ONLY LOAD THE DEPARTMENT REQUESTED (makes using first() ok below)
		->with(['departmentUser' => function($q) use ($dept_id) {
			$q->where('department_id', 'academic_departments:'.$dept_id);
		}])
		->get();
 
		// Build Department Listing
		$deptList = '';

		foreach ($persons as $person) {
			$deptList .= "
			<h3 class='jewel-common-name'>{$person->common_name}</h3>
			<ul>
				<li class='jewel-role-name'><strong>Role: </strong>{$person->departmentUser->first()->role_name}</li>
				<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$person->email}'>{$person->email}</a></li>
				<li class='jewel-bio'><strong>Biography: </strong>{$person->biography}</li>
				<li class='jewel-url'><a href='https://faculty-demo.sandbox.csun.edu/people/{$person->getEmailURIAttribute()}'>View Profile</a></li>
			</ul>";
		}

		// Remove Newline & Tabs
		$deptList = preg_replace('/(\\n)|(\\t)/', '', $deptList);
		
		// Optional HTML Formatting
		if (\Request::get('format') == 'html') {
			return $deptList;
		}

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
