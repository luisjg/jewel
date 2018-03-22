<?php

namespace App\Http\Controllers;

use App\Handlers\HandlerUtilities;
use Illuminate\Support\Facades\File;
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

    /**
     * Finds or creates a directory given the name and
     * returns true or false.
     *
     * @param string $name the directory name to create
     * @return bool
     */
    protected function findOrCreateDirectory($name)
    {
        if (!File::exists(storage_path($name))) {
            return File::makeDirectory(storage_path($name));
        }
        return true;
    }
}
