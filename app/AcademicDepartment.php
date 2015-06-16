<?php namespace Jewel;

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

	/**
	 * Returns the academic group associated with this department.
	 *
	 * @return Builder|Model
	 */
	public function academicGroup() {
		return $this->belongsTo("Jewel\AcademicGroup", "college_id", "department_id");
	}
}