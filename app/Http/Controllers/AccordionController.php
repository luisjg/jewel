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

		// generate the main accordion element markup
		foreach($data as $item) {
			$markup .= "
				<h2 class=\"field field-name-field-title-text field-type-text field-label-hidden\">
					{$item['header']}
				</h2>
				<div class=\"field field-name-field-body field-type-text-long field-label-hidden\">
					<p>{$item['content']}</p>
				</div>
			";
		}

		// create the JS to make the markup function as an accordion
		$script = "
			Drupal.behaviors.csunThemeLoad($('.jewel-accordion'));
		";

		$markup = "
			<div class=\"jewel-accordion\">
				<div id=\"accordion\">
					{$markup}
				</div>
			</div>
			<script type=\"text/javascript\">
				{$script}
			</script>
		";

		// remove any control characters and send the response
		$markup = HandlerUtilities::removeControlCharacters($markup);
		return $this->sendResponse($markup);
	}
}