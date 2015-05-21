<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $table = 'faculty.users';			
	protected $primaryKey = 'user_id';
	protected $fillable = [];

	public function DepartmentUser(){
		$this->belongsToMany('Jewel\DepartmentUser', 'department_user', 'user_id');
	}

}
