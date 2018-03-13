<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityUser extends Model
{

	protected $table = 'faculty.entity_user';
	protected $primaryKey = 'user_id';
	public $incrementing = false;

	public function Person() {
		return $this->belongsTo('App\Models\Person', 'user_id');
	}

	/**
	 * Returns the center to which this user belongs.
	 *
	 * @return Builder|Model
	 */
	public function center() {
		return $this->belongsTo('App\Models\Center', 'parent_entities_id');
	}

	/**
	* Returns the institute to which this user belongs.
	*
	* @return Builder|Model
	*/
	public function institute() {
		return $this->belongsTo('App\Models\Insitute', 'parent_entities_id');
	}

}

