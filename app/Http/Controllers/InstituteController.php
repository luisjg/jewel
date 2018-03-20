<?php

namespace App\Http\Controllers;

use App\Classes\DataHandler;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Process\Process;

class InstituteController extends Controller
{

    /**
     * This is the entry point for the
     * /api/institutes end point
     *
     * @return Response
     */
    public function showData()
	{
		$institute_id = Request::get('institute_id');
		return $this->showPeople($institute_id);
	}

	/**
	 * Display a listing of the people in the given institute
	 *
	 * @param string $institute_id The system name of the institute
	 * @return Response
	 */
	public function showPeople($institute_id)
	{
        if (File::exists(storage_path('institutes/' . $institute_id . '.txt'))) {
            $entityList = File::get(storage_path('institutes/' . $institute_id. '.txt'));
            $process = new Process('php ../artisan update:institutes ' . $institute_id . ' > /dev/null &');
            $process->start();
        } else {
            $entityList = DataHandler::getInstituteData($institute_id);
            File::makeDirectory(storage_path('institutes'));
            File::put(storage_path('institutes/' . $institute_id . '.txt'), $entityList);
        }
		// send the response
		return $this->sendResponse($entityList);
	}
}