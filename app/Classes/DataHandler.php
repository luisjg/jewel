<?php

namespace App\Classes;

use App\Handlers\HandlerUtilities;
use App\Models\Committee;
use App\Models\Contact;
use App\Models\Person;

class DataHandler
{
    /**
     * Retrieves the formatted department data
     *
     * @param string $dept_id
     * @return string
     */
    public static function getDepartmentData($dept_id)
    {
        // RETURN PEOPLE WHO HAVE DEPARTMENT
        $persons = Person::whereHas('departmentUser', function ($q) use ($dept_id) {
            $q->where('department_id', 'academic_departments:' . $dept_id);
        })
            // DO NOT LIST THE DECEASED
            ->where('deceased', '0')
            // DO NOT LIST THE INACTIVE
            ->where('affiliation_status', 'Active')
            // GRAB THE IMAGE
            // ONLY LOAD THE DEPARTMENT REQUESTED (makes using first() ok below)
            ->with(['departmentUser' => function ($q) use ($dept_id) {
                $q->where('department_id', 'academic_departments:' . $dept_id);
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
            'chair' => '',
            'faculty' => '',
            'Lecturer' => '',
            'Emeriti' => ''
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

            // Assign Faculty
            $role_name = $person->affiliation;

            // Assign Chair
            if ($chair) {
                $role_name = $chair->role_name;
            }

            // Assign Emeriti
            if ($person->affiliation == 'emeritus') {
              $role_name = 'Emeriti';
            }

            //Assign Lecturers
            if ($person->rank == 'Lecturer') {
              $role_name = 'Lecturers';
            }

          // Interpolate & Append Markup
          if (array_key_exists($role_name, $roles)) {
            //Check if user has an official e-mail set, otherwise assign defaults
            if (!empty($person->email_u_r_i)) {
              $profile_url = config('webservices.faculty') . $person->email_u_r_i ;
              $image_url = config('app.image_location') . $person->email_u_r_i . '/avatar';
            } else {
              $profile_url = config('webservices.faculty');
              $image_url = config('webservices.faculty') . 'imgs/profile-default.png';
            }
            $roles[$role_name] .= "
				<div class='jewel-media'>
					<div class='jewel-media-left'>
						<img class='jewel-img' src='{$image_url}' alt='{$person->display_name}' height='150px'>
					</div>
					<div class='jewel-media-body'>
						<ul class='jewel'>
							<li class='jewel-faculty-name'><h3 class='jewel-display-name'>{$person->display_name}</h3></li>
							<li class='jewel-role-name'>{$person->rank}</li>
							<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$department_email}'>{$department_email}</a></li>
              <li class='jewel-url'><a target='_blank' href='{$profile_url}'>Faculty Profile</a></li>
            </ul>
					</div>
				</div>
				";
          }
        }

        // Build Department Listing
        $deptList = self::applyJewelCss();

      foreach ($roles as $role => $data) {
        if (!empty($data)) {
          $deptList .= "<div><h2 style='clear:both' id='" . strtolower($role) . "'><hr>" . ucwords($role) . "<hr></h2>{$data}</div>";
        }
      }

        // remove control characters from the output
        return HandlerUtilities::removeControlCharacters($deptList);
    }

    /**
     * Retrieves the formatted institute data
     *
     * @param string $institute_id
     * @return string
     */
    public static function getInstituteData($institute_id)
    {
        //
        $persons = Person::whereHas('entityUser', function ($q) use ($institute_id) {
            $q->where('parent_entities_id', 'institutes:' . $institute_id);
        })
            //
            ->with('image')
            //
            ->with(['entityUser' => function ($q) use ($institute_id) {
                $q->where('parent_entities_id', 'institutes:' . $institute_id);
            }])
            ->orderBy('last_name')->orderBy('first_name')
            ->get();

        // Separate Data By Role
        $roles = [
            'director' => '',
            'staff' => '',
            'affiliate' => ''
        ];

        foreach ($persons as $person) {

            // Grab Person
            $institutes = collect($person->entityUser->all());

            // Check if Person is the Director
            $director = $institutes->where('role_name', 'director')->first();

            // Assign Director and Run the rest of the Institute Listing
            if ($director) {
                $role_name = $director->role_name;

            } else {
                $role_name = $person->entityUser->first()->role_name;

                // Assign Staff
                if ($person->rank == 'staff') {
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
							<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$person->email}'>{$person->email}</a></li>
							<li class='jewel-url'><a target='_blank' href='//www.csun.edu/faculty/profiles/{$person->email_u_r_l}'>View Profile</a></li>
						</ul>
					</div>
				</div>
				";
            }
        }

        // Build Listing
        $entityList = self::applyJewelCss();

        foreach ($roles as $role => $data) {
            if (!empty($data)) {
                $entityList .= "<h2 id='" . strtolower($role) . "'>" . ucwords($role) . "</h2>${data}<hr>";
            }
        }

        // remove control characters from the output
        return HandlerUtilities::removeControlCharacters($entityList);
    }

    /**
     * Returns the formatted committee data
     *
     * @param string $committee_id the committee to look up
     * @return string
     */
    public static function getCommitteeData($committee_id)
    {
        // grab the committee with its associated people (ordered by their names)
        $committee = Committee::with(['people' => function ($q) {
            $q->orderBy('last_name')->orderBy('first_name');
        }])->findOrFail("committees:{$committee_id}");

        // grab the committee attributes from its description ([key:value]|[key:value]|etc...)
        $attr = HandlerUtilities::attributesToArray($committee->description);

        // separate the people by their specific roles
        $roles = [
            'chair' => '',
            'member' => '',
            '__divider' => '<tr><td colspan=\'5\' style=\'text-align:center;font-weight:bold\'>Non-Voting</td></tr>',
            'executive_secretary' => '',
            'recording_secretary' => '',
            'permanent_guest' => ''
        ];

        // iterate over the associated people and add them to the respective key
        foreach ($committee->people as $person) {
            $position = $person->pivot->role_position;
            if (array_key_exists($position, $roles)) {
                // figure out when the position expires
                $status = $person->pivot->member_status;
                $expiration = (($status == "Active") ? "" : str_replace("expires:", "", $status));

                // figure out the membership display depending on the committee type
                $person->load('departmentUser');
                $memberOf = "Unknown";

                // make sure the user exists as a departmentUser to prevent
                // exceptions from being thrown
                if ($person->departmentUser->count() > 0) {
                    $person->departmentUser->load('department');

                    if ($attr['type'] == "departments") {
                        // committee made up of department representatives
                        if ($person->departmentUser[0]->department == NULL) {
                            $memberOf = 'Unknown';
                        } else {
                            $memberOf = $person->departmentUser[0]->department->name;
                        }
                    } else {
                        // ensure the person is a member of a resolvable department first
                        if ($person->departmentUser[0]->department != null) {
                            // committee made up of college representatives (academic groups)
                            $person->departmentUser[0]->department->load('academicGroup');
                            if ($person->departmentUser[0]->department->academicGroup == NULL) {
                                $memberOf = 'Unknown';
                            } else {
                                $memberOf = $person->departmentUser[0]->department->academicGroup->name;
                            }
                        } else {
                            $memberOf = 'Unknown';
                        }
                    }
                }

                // escape necessary data
                $memberOf = e($memberOf);

                // generate the name of the role
                $roleName = ucwords(str_replace("_", " ", $position));

                // should there be a link to a Faculty profile?
                $nameMarkup = $person->display_name;
                if (($position == "chair" || $position == "member") && $person->affiliation != "student") {
                    $nameMarkup = "<a href='//www.csun.edu/faculty/profiles/{$person->email_uri}' target='_blank'>$nameMarkup</a>";
                } else {
                    // grab their contact information from their primary contact
                    // and use that in place of the "Member Of" column for something
                    // that isn't a committee
                    $contact = Contact::where('entities_id', $person->individuals_id)
                        ->where("parent_entities_id", "NOT LIKE", "committees:%")
                        ->orderBy('precedence', 'ASC')
                        ->first();

                    if (!empty($contact)) {
                        $memberOf = $contact->title;
                    }

                }

                // add the data to the proper key
                $roles[$position] .= "
				<tr>
					<td>{$nameMarkup}</td>
					<td>{$roleName}</td>
					<td>{$person->pivot->description}</td>
					<td>{$memberOf}</td>
					<td>{$expiration}</td>
				</tr>
				";
            }
        }

        // convert everything to HTML
        $data = "<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Role</th>
					<th>Appointed or Elected By</th>
					<th>Member Of</th>
					<th>Term Expires</th>
				</tr>
			</thead>
			<tbody>";
        $data .= implode("", $roles);
        $data .= "</tbody></table>";

        // remove control characters from the output
        return HandlerUtilities::removeControlCharacters($data);
    }

    public static function getCenterData($center_id)
    {
        //
        $persons = Person::whereHas('entityUser', function($q) use ($center_id) {
            $q->where('parent_entities_id', 'centers:'.$center_id);
        })
            //
            ->with('image')
            //
            ->with(['entityUser' => function($q) use ($center_id) {
                $q->where('parent_entities_id', 'centers:'.$center_id);
            }])
            ->orderBy('last_name')->orderBy('first_name')
            ->get();

        // Separate Data By Role
        $roles = [
            'director' => '',
            'staff' => '',
            'affiliate' => ''
        ];

        foreach ($persons as $person) {

            // Grab Person
            $centers = collect($person->entityUser->all());

            // Check if Person is the Director
            $director = $centers->where('role_name', 'director')->first();

            // Assign Director and Run the rest of the Center Listing
            if($director){
                $role_name = $director->role_name;

            } else{
                $role_name = $person->entityUser->first()->role_name;

                // Assign Staff
                if($person->rank == 'staff') {
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
							<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$person->email}'>{$person->email}</a></li>
							<li class='jewel-url'><a target='_blank' href='//www.csun.edu/faculty/profiles/{$person->email_u_r_i}'>View Profile</a></li>
						</ul>
					</div>
				</div>
				";
            }
        }

        // Build Listing
        $entityList = self::applyJewelCss();

        foreach ($roles as $role => $data) {
            if (!empty($data)) {
                $entityList .= "<h2 id='" . strtolower($role) . "'>".ucwords($role)."</h2>${data}<hr>";
            }
        }

        // remove control characters from the output
        return HandlerUtilities::removeControlCharacters($entityList);
    }

    /**
     * Applies the Jewel Css
     *
     * @return string
     */
    private static function applyJewelCss()
    {
        return "
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
    }
}