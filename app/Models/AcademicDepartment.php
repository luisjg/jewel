<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicDepartment extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'faculty.departments';

	/**
	 * Primary key in the table relationship.
	 *
	 * @var string
	 */
	protected $primaryKey = 'department_id';

	public $incrementing = false;

	/**
	 * Returns the academic group associated with this department.
	 *
	 * @return Builder|Model
	 */
	public function academicGroup() {
		return $this->belongsTo("App\Models\AcademicGroup", "college_id", "department_id");
	}
}