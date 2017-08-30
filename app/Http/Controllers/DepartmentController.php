<?php namespace Jewel\Http\Controllers;

use Jewel\Handlers\HandlerUtilities;

use Jewel\Http\Controllers\Controller;
use Request;

use Jewel\Department;
use Jewel\Person;
use Jewel\Http\Controllers\Response;
use Jewel\Contact;


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
		// DO NOT LIST THE DECEASED
		->where('deceased', '0')
        // DO NOT LIST THE INACTIVE
        ->where('affiliation_status', 'Active')
		// GRAB THE IMAGE
		->with('image')
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

			// Grab Person Departments
			$departments = collect($person->departmentUser->all());

			// Check if Person is a Chair
			$chair = $departments->where('role_name', 'chair')->first();

			//Retrieve department email

            $contact = Contact::where('entities_id', $person->individuals_id)
            ->where('parent_entities_id', $person->departmentUser[0]->department_id)
            ->first();

            if (!empty($contact) && !empty($contact->email)) {
                $department_email = $contact->email;
            } else {
                $department_email = $person->email;
            }

			// Assign Chair and Run the rest of the Department Listing
			if($chair){
				$role_name = $chair->role_name;
				
			} else{
				$role_name = $person->affiliation;

					// Assign Lecturers
				if($person->rank == 'Lecturer') {
						$role_name = $person->rank;
				}

			}

			// Interpolate & Append Markup
			if (array_key_exists($role_name, $roles)) {
				$roles[$role_name] .= "
				<div class='jewel-media'>
					<div class='jewel-media-left'>
						<img class='jewel-img' src='{$person->profile_image_url}' alt='Image of {$person->display_name}'>
					</div>
					<div class='jewel-media-body'>
						<ul class='jewel'>
							<li class='jewel-faculty-name'><h3 class='jewel-display-name'>{$person->display_name}</h3></li>
							<li class='jewel-role-name'>{$person->rank}</li>
							<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$department_email}'>{$department_email}</a></li>
							<li class='jewel-url'><a target='_blank' href='http://www.csun.edu/faculty/profiles/{$person->getEmailURIAttribute()}'>View Profile</a></li>
						</ul>
					</div>
				</div>
				";
			}
		}

		// Build Department Listing
		$deptList = "
		<style> 
			.jewel-media{
				margin: 25px 0;
			}
			.jewel-media-left{
			    display: table-cell;
    			vertical-align: middle;
			}
			.jewel-media-body{
				display: table-cell;
    			vertical-align: middle;
    			width: 500px;
			}
			.jewel-url a{
				color: #CF0A2C;
			}
			.jewel-img {
				float: left;
				max-width: 150px;
				display: block;
				vertical-align: middle;
			}
			.jewel-role-name{
				font-size: 1.15em;
			}
			.jewel-display-name{
				color: #4a4a4a;
			    font-size: 1.4em;
    			margin: 5px 0;
			}
			.jewel{
				color: #4a4a4a;
				list-style:outside none;
				clear: both;
			}
		</style> 
		";

		foreach ($roles as $role => $data) {
			$deptList .= "<h2 id='" . strtolower($role) . "'>".ucwords($role)."</h2>${data}<hr>";
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
