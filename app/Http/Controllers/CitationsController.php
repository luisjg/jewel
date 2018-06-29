<?php

namespace App\Http\Controllers;

use App\Classes\DataHandler;
use App\Handlers\HandlerUtilities;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Process\Process;

use CSUNMetaLab\Guzzle\Factories\HandlerGuzzleFactory;

class CitationsController extends Controller
{
	/**
	 * The HandlerGuzzle instance.
	 *
	 * @var HandlerGuzzle
	 */
	protected $guzzle;

	/**
	 * Constructs a new CitationsController instance.
	 */
	public function __construct() {
		$this->guzzle = HandlerGuzzleFactory::fromDefaults();
	}

	/**
	 * Displays citations for faculty publications for a specific college.
	 *
	 * @param int $college_id The numeric ID of the college
	 * @return Response
	 */
	public function showCollegeCitations($college_id) {
		$url = config('webservices.citations') . "colleges/{$college_id}/citations";
		$years = [];
		$markup = "";

		// make the call and resolve the response body
		$response = $this->guzzle->get($url);
		$body = $this->guzzle->resolveResponseBody($response, 'json');
		$citations = $body->citations;

		// iterate over the citations and add the non-thesis instances that
		// are already pre-formatted and published
		foreach($citations as $citation) {
			if($citation->type != 'thesis' && $citation->is_published == 'true'
				&& !empty($citation->formatted)) {
				// we want to pull the year component of the date
				$pieces = explode('-', $citation->published->date);
				$year = $pieces[0];

				$abstract = (!empty($citation->metadata->abstract) ?
					$citation->metadata->abstract :
					"No abstract available");

				// generate the content section
				$content = "
					<p>
						<strong>Abstract:</strong>
					</p>
					<p>
						{$abstract}
					</p>
				";

				$years[$year][] = [
					'header' => $citation->formatted,
					'content' => $content,
				];
			}
		}

		// order the years array in descending order
		krsort($years);

		// generate the markup for each element
		foreach($years as $year => $data) {
			$markup .= "<h3>{$year}</h3>";

			// generate the accordion for the year section
			$markup .= HandlerUtilities::weboneAccordionFromArray($data);
		}

		// create the JS to make the markup function as an accordion
        $markup .= "
        <script type=\"text/javascript\">
            (function ($) {
                Drupal.attachBehaviors($('.jewel-accordion'));
            })(jQuery);
		</script>
        ";

		// remove any control characters, and then send the response
		$markup = HandlerUtilities::removeControlCharacters($markup);
		return $this->sendResponse($markup);
	}
}