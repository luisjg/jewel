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

		// GETS ALL THE MEMBERS OF AN ACADEMIC DEPARTMENT FROM DIRECTORY
		try {
			$client = new \GuzzleHttp\Client();

			$response = $client->get("https://directory-demo.sandbox.csun.edu/academic_departments/{$dept_id}/members/full");
			$people = $response->json();
			// $people = $people['person'];
		}
		catch(\Exception $e)
		{
			$people = [
				// WE NEED A BETTER WAY OF HANDLING THIS
				"status" => "503",
				"success" => "false",
				"classes" => []
			];
		}
		// RETURN PEOPLE WHO HAVE DEPARTMENT
		// $persons = Person::whereHas('departmentUser', function($q) use ($dept_id) {
		// 	$q->where('department_id', 'academic_departments:'.$dept_id);
		// })
		// // GRAB THE IMAGE
		// ->with('image')
		// // ONLY LOAD THE DEPARTMENT REQUESTED (makes using first() ok below)
		// ->with(['departmentUser' => function($q) use ($dept_id) {
		// 	$q->where('department_id', 'academic_departments:'.$dept_id);
		// }])
		// ->orderBy('last_name')->orderBy('first_name')
		// ->get();

		// Separate Data By Role
		$roles = [
			'chair'=>'',
			'faculty' =>'',
			'professor' =>'',
			'Lecturer'=>'',
			'emeritus'=>''
		];
		//Get Department Chair
		foreach ($people as $person => $value) {
			foreach ($value['department_user'] as $department_user => $rank) {
				if ($rank['role_name']=='chair'){
					$chair = $value;
					return $chair;
				}
			}
		}

		//Get Department Professors
		foreach ($people as $person => $value) {
			if ($value['rank']=='Professor'){
				$professor = $value;
				return $professor;
			}
		}
		// //Get Department Lecturers
		foreach ($people as $person => $value) {
			if ($value['rank']=='Lecturer'){
				$lecturer = $value;
				return $lecturer;
			}
		}	

		// foreach ($people as $person => $value) {
		// 	if ($rank['rank']=='Lecturer'){
		// 		$Lecturer = $value;
		// 		return $Lecturer;
		// 	}
		// }

			// dd($value['department_user']);

			// Grab Person Departments
			// $departments = collect($person->departmentUser->all());

			// Check if Person is a Chair
		
			// $chair = $person['role_name'=> 'chair']->first();

			// Assign Chair and Run the rest of the Department Listing
		// 	if($chair){
		// 		$role_name = $chair->role_name;
				
		// 	} else{
		// 		$rank = $person->first()->rank;

		// 			// Assign Lecturers
		// 			if($person->rank == 'Lecturer') {
		// 				$rank= $person->rank;
		// 		}
		// 		else{
		// 		$rank = $person->first()->rank;

		// 			// Assign Professor
		// 			if($person->rank == 'Professor') {
		// 				$rank= $person->rank;
		// 		}
		// 	}
		
		// }
		
			// Grab Faculty Profile Image
			// if(!$person->image){
			// 	$img = 'imgs/profile-default.png';
			// } else {
			// 	$img = 'uploads/imgs/'.$person->image->src;
			// }

			// Interpolate & Append Markup
			// if (array_key_exists($role_name, $roles)) {
			// 	$roles[$role_name] .= "
			// 	<div class='jewel-media'>
			// 		<div class='jewel-media-left'>
			// 			<img class='jewel-img' src='https://www.metalab.csun.edu/faculty/{$img}' alt='Image of {$person->display_name}'>
			// 		</div>
			// 		<div class='jewel-media-body'>
			// 			<ul class='jewel'>
			// 				<li class='jewel-faculty-name'><h3 class='jewel-display-name'>{$person->display_name}</h3></li>
			// 				<li class='jewel-role-name'>{$person->rank}</li>
			// 				<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$person->email}'>{$person->email}</a></li>
			// 				<li class='jewel-url'><a target='_blank' href='http://www.csun.edu/faculty/profiles/{$person->getEmailURIAttribute()}'>View Profile</a></li>
			// 			</ul>
			// 		</div>
			// 	</div>
			// 	";
			// }
		}

		// // Build Department Listing
		// $deptList = "
		// <style> 
		// 	.jewel-media{
		// 		margin: 25px 0;
		// 	}
		// 	.jewel-media-left{
		// 	    display: table-cell;
  //   			vertical-align: middle;
		// 	}
		// 	.jewel-media-body{
		// 		display: table-cell;
  //   			vertical-align: middle;
  //   			width: 500px;
		// 	}
		// 	.jewel-url a{
		// 		color: #CF0A2C;
		// 	}
		// 	.jewel-img {
		// 		float: left;
		// 		max-width: 150px;
		// 		display: block;
		// 		vertical-align: middle;
		// 	}
		// 	.jewel-role-name{
		// 		font-size: 1.15em;
		// 	}
		// 	.jewel-display-name{
		// 		color: #4a4a4a;
		// 	    font-size: 1.4em;
  //   			margin: 5px 0;
		// 	}
		// 	.jewel{
		// 		color: #4a4a4a;
		// 		list-style:outside none;
		// 		clear: both;
		// 	}
		// </style> 
		// ";

		// foreach ($roles as $role => $data) {
		// 	$deptList .= "<h2 id='" . strtolower($role) . "'>".ucwords($role)."</h2>${data}<hr>";
		// }

		// // remove control characters from the output
		// $deptList = HandlerUtilities::removeControlCharacters($deptList);

		// // send the response
		// return $this->sendResponse($deptList);
	// }

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
