<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class AcademicGroup extends Model
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
	protected $primaryKey = 'college_id';

	/**
	 * Returns the academic departments associated with this group.
	 *
	 * @return Builder|Model
	 */
	public function departments() {
		return $this->hasMany("Jewel\AcademicDepartment", "department_id", "college_id");
	}
}