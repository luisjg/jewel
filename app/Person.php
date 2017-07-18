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

    /**
     * Returns the email URI for this Person without the domain suffix
     *
     * @return string
     */
    public function getEmailURIAttribute() {
        return strtok(strtolower($this->email), '@');
    }

    /**
     * Returns the full URL to the profile image for this Person. If no profile
     * image can be resolved it returns the full URL to a default placeholder
     * image.
     *
     * @return string
     */
    public function getProfileImageURLAttribute() {
        if ($this->image) {
            if(env('IMAGE_VIEW_LOCATION')) {
                return env('IMAGE_VIEW_LOCATION') . $this->emailURI .
                    '/' . $this->image->src;
            }
            return asset('uploads/imgs/' . $this->emailURI .
                '/' . $this->image->src);
        }
        return asset('imgs/profile-default.png');
    }

}