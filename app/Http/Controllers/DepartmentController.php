<?php

namespace App\Http\Controllers;
use App\Handlers\HandlerUtilities;

use App\Classes\DataHandler;
use App\Models\AcademicGroup;
use App\Models\Person;
use App\Models\Contact;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

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
	 * @return Response|mixed
	 */
	public function showPeople($dept_id)
	{
	    if (File::exists(storage_path('departments/' . $dept_id . '.txt'))) {
	        $deptList = File::get(storage_path('departments/' . $dept_id. '.txt'));
	        $process = new Process('php ../artisan update:departments ' . $dept_id . ' > /dev/null &');
	        $process->start();
        } else {
            $deptList = DataHandler::getDepartmentData($dept_id);
            if ($this->findOrCreateDirectory('departments')) {
                File::put(storage_path('departments/' . $dept_id . '.txt'), $deptList);
            }
        }
		// send the response
		return $this->sendResponse($deptList);
	}

  /**
   * Display a listing of the people in the given college.
   *
   * @param integer $college_id The ID of the academic group
   * @return Response|mixed
   */
  public function showCollegePeople($college_id)
  {
    $academic_group_id = 'academic_groups:' . $college_id;

    // Temporary route that should be refactored and implemented appropriately later
    $leads = DB::table('nemo.memberships')->where('parent_entities_id',$academic_group_id)->whereIn('role_position',['dean','associate_dean','special_assistant'])->get();

    $dean_id = $associate_dean_id = $special_assistant_id = [];

    foreach($leads as $lead) {
      if ($lead->role_position == 'dean') {
        $dean_id[] = $lead->individuals_id;
      }
      if ($lead->role_position == 'associate_dean') {
        $associate_dean_id[] = $lead->individuals_id;
      }
      if ($lead->role_position == 'special_assistant') {
        $special_assistant_id[] = $lead->individuals_id;
      }
    }

    $departments = AcademicGroup::where('college_id', $academic_group_id)->get();

    $dept_id = $departments->pluck('department_id')->toArray();

    $persons = Person::whereHas('departmentUser', function ($q) use ($dept_id) {
      $q->whereIn('department_id', $dept_id);
    })
    ->with('image')
    // DO NOT LIST THE DECEASED
    ->where('deceased', '0')
    // DO NOT LIST THE INACTIVE
    ->where('affiliation_status', 'Active')
    // GRAB ONLY TENURED OR TENURE-TRACK
    ->where('rank', 'like', '%professor%')
    // GRAB ONLY ACTIVE FACULTY
    ->where('affiliation', 'faculty')
    // GRAB THE IMAGE
    // ONLY LOAD THE DEPARTMENT REQUESTED (makes using first() ok below)
    ->with(['departmentUser' => function ($q) use ($dept_id) {
      $q->whereIn('department_id', $dept_id);
    }])
    ->orderBy('last_name')->orderBy('first_name')
    ->get();

    // Generate array of individuals_id's in order to get their contact email
    // We get the contacts here in one shot then filter based on
    // individuals department below.
    $memberIds = $persons->pluck('individuals_id')->toArray();
    $contacts = Contact::where('entities_id', $memberIds)->get();
    // Separate Data By Role
    $roles = [
        'Dean' => '',
        'Associate Dean' => '',
        'Special Assistant to the Dean' => '',
        'Department Chairs' => '',
        'faculty' => ''
    ];

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

      // Assign Dean, Associate Dean, and Chairs
      if ($chair) {
        $role_name = "Department Chairs";
      } else if (in_array($person->individuals_id, $dean_id)) {
          $role_name = 'Dean';
      } else if (in_array($person->individuals_id, $associate_dean_id)) {
          $role_name = 'Associate Dean';
      } else if (in_array($person->individuals_id, $special_assistant_id)) {
          $role_name = 'Special Assistant to the Dean';
      } else {
          $role_name = $person->affiliation;
      }

      // Interpolate & Append Markup
      if (array_key_exists($role_name, $roles)) {
        //Check if user has an official e-mail set, otherwise assign defaults
        if (!empty($person->email_u_r_i)) {
          $profile_url = env('FACULTY_PROFILE_URL') . $person->email_u_r_i ;
          $image_url = env('IMAGE_VIEW_LOCATION') . $person->email_u_r_i . '/avatar';
        } else {
          $profile_url = env('FACULTY_PROFILE_URL');
          $image_url = env('FACULTY_PROFILE_URL') . 'imgs/profile-default.png';
        }
        $roles[$role_name] .= "
				<div class='jewel-media'>
					<div class='jewel-media-left'>
						<img class='jewel-img' src='{$image_url}' alt='Image of {$person->display_name}' height='150px'>
					</div>
					<div class='jewel-media-body'>
						<ul class='jewel'>
							<li class='jewel-faculty-name'><h3 class='jewel-display-name'>{$person->display_name}</h3></li>
							<li class='jewel-role-name'>{$person->rank} <br> {$person->departmentUser[0]->department->name}</li>
							<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$department_email}'>{$department_email}</a></li>
              <li class='jewel-url'><a target='_blank' href='{$profile_url}'>Faculty Profile</a></li>
            </ul>
					</div>
				</div>
				";
      }
    }

    // Build College Listing
    $collegeList = DataHandler::applyJewelCss();

    foreach ($roles as $role => $data) {
      if (!empty($data)) {
        $collegeList .= "<div><h2 style='clear:both' id='" . strtolower($role) . "'><hr>" . ucfirst($role) . "<hr></h2>{$data}</div>";
      }
    }

    // remove control characters from the output
    return $this->sendResponse(HandlerUtilities::removeControlCharacters($collegeList));
  }
}