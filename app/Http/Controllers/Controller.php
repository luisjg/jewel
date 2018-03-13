<?php

namespace App\Http\Controllers;

use App\Handlers\HandlerUtilities;
use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Parses the request type and sends the appropriate
     * Response
     *
     * @param Collection $data the data object.
     * @return mixed
     */
    protected function sendResponse($data)
    {
        if (Request::get('web-one') === 'true') {
            $data = HandlerUtilities::addWebOneStyle($data);
        }

        if (Request::get('format') === 'html') {
            return $data;
        }

        return response()->json([['data' => $data]]);
    }
}
