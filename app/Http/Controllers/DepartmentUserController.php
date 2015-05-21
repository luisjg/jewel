<?php namespace Jewel\Http\Controllers;

use Jewel\Http\Requests;
use Jewel\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Jewel\DepartmentUser;
use Jewel\Person;

class DepartmentUserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$deptList = DepartmentUser::with('Person')->where('department_id', 'academic_departments:189')->get();
		return $deptList;
		
		// return response()->json(['data' => $users]);
		//                  // ->setCallback($request->input('callback'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
