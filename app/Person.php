<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

	protected $table = 'fresco.people';			
	protected $primaryKey = 'individuals_id';
	protected $fillable = [];

	public function departmentUser() {
		return $this->hasMany('Jewel\DepartmentUser', 'user_id');
	}

	public function entityUser() {
		return $this->hasMany('Jewel\EntityUser', 'user_id');
	}

	public function image() {
		return $this->hasOne('Jewel\Image', 'imageable_id');
	}

	public function getEmailURIAttribute() {
	    return strtok($this->email, '@');
	}

}