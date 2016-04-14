<?php namespace Jewel\Http\Controllers;

use Jewel\Handlers\HandlerUtilities;

use Jewel\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Jewel\Committee;
use Jewel\Contact;
use Jewel\Http\Controllers\Response;

class CommitteeController extends Controller {

	/**
	 * Returns a listing of all people in the specified committee.
	 *
	 * @param string $committee_id The short ID of the committee
	 * @return Response
	 */
	public function showPeople($committee_id) {

		// GET ALL MEMBERS IN A COMMITTEE
		try {
			$client = new \GuzzleHttp\Client();

			$response = $client->get("https://directory-demo.sandbox.csun.edu/committees/{$committee_id}/members");
			$people = $response->json();
		}
		catch(\Exception $e)
		{
			$people = [
				// WE NEED A BETTER WAY OF HANDLING THIS
				"status" => "503",
				"success" => "false",
				"members" => []
			];
		}


		// chair, executive secretary, recording sedretary, members, permanent_guest

	
		//return $people;
		
	

		foreach ($people['people'] as $person => $value) {
			
			if($value['pivot']['role_position']=='chair'){
				$chairs[] = array('affiliation' => $value['affiliation'],'rank' => $value['rank'], 'role' => $value['pivot']['role_position'], 'name' => $value['display_name'], 'email' => $value['email']);
			}
		}
	

		foreach ($people['people'] as $person => $value2) {
			
			if($value2['pivot']['role_position']=='executive_secretary'){
				$execSecretary[] = array('affiliation' => $value2['affiliation'], 'rank' => $value2['rank'],'role' => $value2['pivot']['role_position'], 'name' => $value2['display_name'], 'email' => $value2['email']);
			}
		}


		foreach ($people['people'] as $person => $value3) {
			
			if($value3['pivot']['role_position']=='member'){
				$members[] = array('affiliation' => $value3['affiliation'],'rank' => $value3['rank'],'role' => $value3['pivot']['role_position'], 'name' => $value3['display_name'], 'email' => $value3['email']);
			}
		}


		foreach ($people['people'] as $person => $value4) {
			
			if($value4['pivot']['role_position']=='permanent_guest'){
				$guests[] = array('affiliation' => $value4['affiliation'],'rank' => $value4['rank'],'role' => $value4['pivot']['role_position'], 'name' => $value4['display_name'], 'email' => $value4['email']);
			
			}
		}

		foreach ($people['people'] as $person => $value5) {
			
			if($value5['pivot']['role_position']=='recording_secretary'){
				$recSecretary[] = array('affiliation' => $value5['affiliation'],'rank' => $value5['rank'],'role' => $value5['pivot']['role_position'], 'name' => $value5['display_name'], 'email' => $value5['email']);
			
			}
		}

	

		if (!isset($chairs)) {
			$chairs = array();
		}
		if (!isset($execSecretary)) {
			$execSecretary = array();
		}
		if (!isset($recSecretary)) {
			$recSecretary = array();
		}
		if (!isset($members)) {
			$members = array();
		}
		if (!isset($guests)) {
			$guests = array();
		}

		$result = array_merge($chairs, $execSecretary, $recSecretary, $members, $guests);
		
		//return $result;


		$output = " ";
		$role = "";
		
		$first = 0;
		$username = "";

		 foreach ($result as $key) {
		 	$exploded = explode ('@', $key['email']);
			$username = $exploded[0];

		 	if($role != $key['role'] && $first++){
		 		$output .= '<hr />';
			}
		 	$output .= "<div class='jewel-media'>";
		 		$output .= "<div class='jewel-media-body'>";
		 				if($role != $key['role']){
						 		$output .= '<h2>'.$key['role'].'</h2>';
						 }
					
                       $output .= "<ul class='jewel'>";
						 	
                            $output .= "<li class='jewel-faculty-name'><h3 class='jewel-display-name'>{$key['name']}</h3></li>";
                            $output .= "<li class='jewel-role-name'>{$key['rank']}</li>";
                            $output .= "<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$key['email']}'>{$key['email']}</a></li>";
                            if($key['affiliation'] == 'faculty'){
                            	$output .= "<li class='jewel-url'><a target='_blank' href='http://www.csun.edu/faculty/profiles/{$username}'>View Profile</a></li>";
                            }
                        $output .= '</ul>';
                    $output .= '</div>';
                $output .= '</div>';

               $role = $key['role'];
		 }

		 $styles = "
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
                color: #CF0A2C ;
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
                color: #4a4a4a ;
                font-size: 1.4em;
               margin: 5px 0;
            }
            .jewel{
                color: #4a4a4a ;
                list-style:outside none;
                clear: both;
            }
        </style> 
        ";

        $output = $styles.$output;
		// grab the committee with its associated people (ordered by their names)
		// $committee = Committee::with(['people' => function($q) {
		// 	$q->orderBy('last_name')->orderBy('first_name');
		// }])->findOrFail("committees:{$committee_id}");

		// grab the committee attributes from its description ([key:value]|[key:value]|etc...)
		// $attr = HandlerUtilities::attributesToArray($committee->description);

		// separate the people by their specific roles
		// $roles = [
		// 	'chair' => '',
		// 	'member' => '',
		// 	'__divider' => '<tr><td colspan=\'5\' style=\'text-align:center;font-weight:bold\'>Non-Voting</td></tr>',
		// 	'executive_secretary' => '',
		// 	'recording_secretary' => '',
		// 	'permanent_guest' => ''
		// ];

		// iterate over the associated people and add them to the respective key
		// foreach($committee->people as $person) {
		// 	$position = $person->pivot->role_position;
		// 	if(array_key_exists($position, $roles)) {
		// 		// figure out when the position expires
		// 		$status = $person->pivot->member_status;
		// 		$expiration = (($status == "Active") ? "" : str_replace("expires:", "", $status));

		// 		// figure out the membership display depending on the committee type
		// 		$person->load('departmentUser');
		// 		$memberOf = "Unknown";
				
		// 		// make sure the user exists as a departmentUser to prevent
		// 		// exceptions from being thrown
		// 		if($person->departmentUser->count() > 0) {
		// 			$person->departmentUser->load('department');
		// 			if($attr['type'] == "departments") {
		// 				// committee made up of department representatives
		// 				$memberOf = $person->departmentUser[0]->department->name;
		// 			}
		// 			else
		// 			{
		// 				// ensure the person is a member of a resolvable department first
		// 				if($person->departmentUser[0]->department != null) {
		// 				// committee made up of college representatives (academic groups)
		// 					$person->departmentUser[0]->department->load('academicGroup');
		// 					$memberOf = $person->departmentUser[0]->department->academicGroup->name;
		// 				}
		// 			}
		// 		}

		// 		// escape necessary data
		// 		$memberOf = e($memberOf);

		// 		// generate the name of the role
		// 		$roleName = ucwords(str_replace("_", " ", $position));

		// 		// should there be a link to a Faculty profile?
		// 		$nameMarkup = $person->common_name;
		// 		if(($position == "chair" || $position == "member") && $person->affiliation != "student") {
		// 			$nameMarkup = "<a href='http://metalab.csun.edu/faculty/profiles/{$person->email_uri}' target='_blank'>$nameMarkup</a>";
		// 		}
		// 		else
		// 		{
		// 			// grab their contact information from their primary contact
		// 			// and use that in place of the "Member Of" column for something
		// 			// that isn't a committee
		// 			$contact = Contact::where('entities_id', $person->individuals_id)
		// 				->where("parent_entities_id", "NOT LIKE", "committees:%")
		// 				->orderBy('precedence', 'ASC')
		// 				->first();

		// 			if(!empty($contact)) {
		// 				$memberOf = $contact->title;
		// 			}
		// 		}

		// 		// add the data to the proper key
		// 		$roles[$position] .= "
		// 		<tr>
		// 			<td>{$nameMarkup}</td>
		// 			<td>{$roleName}</td>
		// 			<td>{$person->pivot->description}</td>
		// 			<td>{$memberOf}</td>
		// 			<td>{$expiration}</td>
		// 		</tr>
		// 		";
		// 	}
		// }

		// convert everything to HTML
		// $data = "<table>
		// 	<thead>
		// 		<tr>
		// 			<th>Name</th>
		// 			<th>Role</th>
		// 			<th>Appointed or Elected By</th>
		// 			<th>Member Of</th>
		// 			<th>Term Expires</th>
		// 		</tr>
		// 	</thead>
		// 	<tbody>";
		// $data .= implode("", $roles);
		// $data .= "</tbody></table>";

		// remove control characters from the output
		$output = HandlerUtilities::removeControlCharacters($output);

		// send the response back
		return $this->sendResponse($output);
	}

}