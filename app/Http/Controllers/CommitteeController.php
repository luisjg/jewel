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
		$data = HandlerUtilities::removeControlCharacters($data);

		// send the response back
		return $this->sendResponse($data);
	}

}