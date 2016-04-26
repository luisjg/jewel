<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class EntityUser extends Model {

	protected $table = 'faculty.entity_user';		
	protected $fillable = [];

	public function Person(){
		return $this->belongsTo('Jewel\Person', 'user_id');
	}

	/**
	 * Returns the center to which this user belongs.
	 *
	 * @return Builder|Model
	 */
	public function center() {
		return $this->belongsTo('Jewel\Center', 'parent_entities_id');
	}

}

