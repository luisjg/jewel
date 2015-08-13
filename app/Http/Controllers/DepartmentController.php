<?php namespace Jewel\Http\Controllers;

use Jewel\Handlers\HandlerUtilities;

use Jewel\Http\Controllers\Controller;
use Request;

use Jewel\Department;
use Jewel\Person;
use Jewel\Http\Controllers\Response;


class DepartmentController extends Controller {

	public function index() {
		//
	}

	// temporary route to support /data?department_id=[dept_id]
	public function showData() {
		$dept_id = Request::get('department_id');
		return $this->showPeople($dept_id);
	}

	/**
	 * Display a listing of the people in the given department.
	 *
	 * @param integer $dept_id The ID of the academic department
	 * @return Response
	 */
	public function showPeople($dept_id)
	{
		// RETURN PEOPLE WHO HAVE DEPARTMENT
		$persons = Person::whereHas('departmentUser', function($q) use ($dept_id) {
			$q->where('department_id', 'academic_departments:'.$dept_id);
		})
		// ONLY LOAD THE DEPARTMENT REQUESTED (makes using first() ok below)
		->with(['departmentUser' => function($q) use ($dept_id) {
			$q->where('department_id', 'academic_departments:'.$dept_id);
		}])
		->orderBy('last_name')->orderBy('first_name')
		->get();

		// Separate Data By Role
		$roles = [
			'chair'=>'',
			'faculty' =>'',
			'Lecturer'=>'',
			'emeritus'=>''
		];
		
		foreach ($persons as $person) {

			// Grab Person Role Name
			$role_name = $person->departmentUser->first()->role_name;

			if($person->rank === 'Lecturer') {
				$role_name = $person->rank;
			}

			// Interpolate & Append Markup
			if (array_key_exists($role_name, $roles)) {
				$roles[$role_name] .= "
				<h3 class='jewel-common-name'>{$person->common_name}</h3>
				<ul>
					<li class='jewel-role-name'>{$person->rank}</li>
					<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$person->email}'>{$person->email}</a></li>
					<li class='jewel-url'><a href='https://faculty-demo.sandbox.csun.edu/profiles/{$person->getEmailURIAttribute()}'>View Profile</a></li>
				</ul>";
			}
		}

		// Build Department Listing
		$deptList = "
		<style>

		</style> 
		";

		foreach ($roles as $role => $data) {
			$deptList .= "<h2 id='{$role}'>".ucwords($role)."</h2>${data}<hr>";
		}

		// remove control characters from the output
		$deptList = HandlerUtilities::removeControlCharacters($deptList);

		// send the response
		return $this->sendResponse($deptList);
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
	public function show($dept_id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($dept_id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($dept_id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($dept_id)
	{
		//
	}

}
