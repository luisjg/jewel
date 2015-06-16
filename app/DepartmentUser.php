<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model {

	protected $table = 'faculty.department_user';		
	protected $fillable = [];

	public function Person(){
		return $this->belongsTo('Jewel\Person', 'user_id');
	}

	/**
	 * Returns the academic department to which this user belongs.
	 *
	 * @return Builder|Model
	 */
	public function department() {
		return $this->belongsTo('Jewel\AcademicDepartment', 'department_id');
	}

}

