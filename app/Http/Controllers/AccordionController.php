<?php

namespace App\Http\Controllers;

use App\Classes\DataHandler;
use App\Handlers\HandlerUtilities;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Process\Process;

class AccordionController extends Controller
{
	/**
	 * Entry point for /api/accordion.
	 *
	 * @return Response
	 */
	public function showData() {
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

		// remove any control characters and send the response
		$markup = HandlerUtilities::removeControlCharacters($markup);
		$markup = HandlerUtilities::weboneAccordionFromArray($markup);
		return $this->sendResponse($markup);
	}
}