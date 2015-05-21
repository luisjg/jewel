<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model {

	protected $table = 'faculty.department_user';			
	protected $primaryKey = 'department_id';
	protected $fillable = [];

	public function Person(){
		return $this->belongsToMany('Jewel\User', 'department_user', 'department_id');
	}

}
