<?php

namespace App\Http\Controllers;

use App\Classes\DataHandler;
use App\Handlers\HandlerUtilities;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Process\Process;

class CitationsController extends Controller
{
	/**
	 * Displays citations for faculty publications for a specific college.
	 *
	 * @param int $college_id The numeric ID of the college
	 * @return Response
	 */
	public function showCollegeCitations($college_id) {
		$markup = "";

		// simulates the structure of an accordion with data
		$data = [
			[
				'header' => 'Generated One',
				'content' => 'Generated Content One',
			],
			[
				'header' => 'Generated Two',
				'content' => 'Generated Content Two',
			],
			[
				'header' => 'Generated Three',
				'content' => 'Generated Content Three',
			],
		];

		// generate the accordion, remove any control characters, and then
		// send the response
		$markup = HandlerUtilities::weboneAccordionFromArray($data);
		$markup = HandlerUtilities::removeControlCharacters($markup);
		return $this->sendResponse($markup);
	}
}