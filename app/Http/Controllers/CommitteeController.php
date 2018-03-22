<?php

namespace App\Http\Controllers;

use App\Classes\DataHandler;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class CommitteeController extends Controller
{

	/**
	 * Returns a listing of all people in the specified committee.
	 *
	 * @param string $committee_id The short ID of the committee
	 * @return Response
	 */
	public function showPeople($committee_id)
    {
        if (File::exists(storage_path('committees/' . $committee_id . '.txt'))) {
            $data = File::get(storage_path('committees/' . $committee_id. '.txt'));
            $process = new Process('php ../artisan update:committees ' . $committee_id.' > /dev/null &');
            $process->start();
        } else {
            $data = DataHandler::getCommitteeData($committee_id);
            if ($this->findOrCreateDirectory('committees')) {
                File::put(storage_path('committees/' . $committee_id . '.txt'), $data);
            }
        }
		// send the response back
		return $this->sendResponse($data);
	}
}