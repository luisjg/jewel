<?php namespace Jewel\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Request;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	/**
	 * Sends the response back using the supplied data.
	 *
	 * @param string The data to send back
	 * @return string|Response
	 */
	protected function sendResponse($data) {
		// Optional HTML Formatting
		if (Request::get('format') == 'html') {
			return $data;
		}

		// Dumb Web-One Needs A Double Casted Array
		return response()->json([['data' => $data]])->setCallback('jsonp_received');
	}

}
