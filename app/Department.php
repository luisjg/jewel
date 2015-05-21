<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table = 'faculty.department_user';		
	protected $fillable = [];

	public function Person(){
		return $this->belongsTo('Jewel\Person', 'user_id');
	}

}

