<?php

namespace App\Http\Controllers;

use App\Classes\DataHandler;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Process\Process;

class DepartmentController extends Controller
{
    // temporary route to support /data?department_id=[dept_id]
    /**
     * This handles the endpoint for both
     * /data and /api/departments
     *
     * @return Response
     */
	public function showData() {
		$dept_id = Request::get('department_id');
		return $this->showPeople($dept_id);
	}

	/**
	 * Display a listing of the people in the given department.
	 *
	 * @param integer $dept_id The ID of the academic department
	 * @return Response|mixed
	 */
	public function showPeople($dept_id)
	{
	    if (File::exists(storage_path('departments/' . $dept_id . '.txt'))) {
	        $deptList = File::get(storage_path('departments/' . $dept_id. '.txt'));
	        $process = new Process('php ../artisan update:departments ' . $dept_id . ' > /dev/null &');
	        $process->start();
        } else {
            $deptList = DataHandler::getDepartmentData($dept_id);
            File::makeDirectory(storage_path('departments'));
            File::put(storage_path('departments/' . $dept_id . '.txt'), $deptList);
        }
		// send the response
		return $this->sendResponse($deptList);
	}
}