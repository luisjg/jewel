<?php

namespace App\Http\Controllers;

use App\Handlers\HandlerUtilities;

use App\Models\Department;
use App\Models\Person;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    // temporary route to support /data?department_id=[dept_id]
    /**
     * This handles the endpoint for both
     * /data and /api/departments
     *
     * @return Response
     */
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
        ->with('image')
        // DO NOT LIST THE DECEASED
        ->where('deceased', '0')
        // DO NOT LIST THE INACTIVE
        ->where('affiliation_status', 'Active')
        // GRAB THE IMAGE
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

		// Generate array of individuals_id's in order to get their contact email
        // We get the contacts here in one shot then filter based on
        // individuals department below.
		$memberIds = $persons->pluck('individuals_id')->toArray();
        $contacts = Contact::where('entities_id', $memberIds)->get();


		foreach ($persons as $person) {

			// Grab Person Departments
			$departments = collect($person->departmentUser->all());

			// Check if Person is a Chair
			$chair = $departments->where('role_name', 'chair')->first();

			// Filter the contact based on the individuals department email
            $contact = $contacts->filter(function ($item) use ($person) {
                if ($item->parent_entities_id === $person->departmentUser[0]->department_id) {
                    return $item;
                }
            });

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
						<img class='jewel-img' src='{$person->profile_image_u_r_l}' alt='Image of {$person->display_name}'>
					</div>
					<div class='jewel-media-body'>
						<ul class='jewel'>
							<li class='jewel-faculty-name'><h3 class='jewel-display-name'>{$person->display_name}</h3></li>
							<li class='jewel-role-name'>{$person->rank}</li>
							<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$department_email}'>{$department_email}</a></li>
							<li class='jewel-url'><a target='_blank' href='http://www.csun.edu/faculty/profiles/{$person->email_u_r_i}'>View Profile</a></li>
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
}