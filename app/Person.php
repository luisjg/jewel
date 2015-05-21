<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

	protected $table = 'faculty.users';			
	protected $primaryKey = 'user_id';
	protected $fillable = [];

	public function department(){
		return $this->hasMany('Jewel\Department', 'user_id');
	}

	public function getEmailURIAttribute() {
	    return strtok($this->email, '@');
	}

}