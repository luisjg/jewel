<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model {

	protected $table = 'faculty.department_user';
	protected $primaryKey = 'department_id';
	public $incrementing = false;

	public function Person(){
		return $this->belongsTo('App\Models\Person', 'user_id', 'user_id');
	}

	/**
	 * Returns the academic department to which this user belongs.
	 *
	 * @return Builder|Model
	 */
	public function department() {
		return $this->belongsTo('App\Models\AcademicDepartment', 'department_id', 'department_id');
	}

}

