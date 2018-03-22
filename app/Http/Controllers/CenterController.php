<?php

namespace App\Http\Controllers;

use App\Classes\DataHandler;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Process\Process;

class CenterController extends Controller
{

    /**
     * This is the entry poin for the
     * /api/centers end point
     *
     * @return Response
     */
    public function showData()
	{
		$center_id = Request::get('center_id');
		return $this->showPeople($center_id);
	}

	/**
	 * Display a listing of the people in the given center
	 *
	 * @param string $center_id The system name of the center
	 * @return Response
	 */
	public function showPeople($center_id)
	{
        if (File::exists(storage_path('centers/' . $center_id . '.txt'))) {
            $data = File::get(storage_path('centers/' . $center_id. '.txt'));
            $process = new Process('php ../artisan update:centers ' . $center_id . ' > /dev/null &');
            $process->start();
        } else {
            $data = DataHandler::getCenterData($center_id);
            if ($this->findOrCreateDirectory('centers')) {
                File::put(storage_path( 'centers/' . $center_id . '.txt'), $data);
            }
        }
		// send the response
		return $this->sendResponse($data);
	}
}