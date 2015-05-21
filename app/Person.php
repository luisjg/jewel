<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

	protected $table = 'faculty.users';			
	protected $primaryKey = 'user_id';
	protected $fillable = [];

	public function departmentUser(){
		return $this->hasMany('Jewel\DepartmentUser', 'user_id');
	}

	public function getEmailURIAttribute() {
	    return strtok($this->email, '@');
	}

}