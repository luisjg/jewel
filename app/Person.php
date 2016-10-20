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

	/**
	 * Returns the full URL to the profile image for this Person. If no profile
	 * image can be resolved it returns the full URL to a default placeholder
	 * image.
	 *
	 * @return string
	 */
	public function getProfileImageURLAttribute() {
		$base = 'https://cdn.metalab.csun.edu/photos/';
		if ($this->image) {
			return $base . $this->image->src;
		}
		return $base . 'profile-default.png';
	}

}