<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

	protected $table = 'fresco.people';			
	protected $primaryKey = 'individuals_id';
	public $incrementing = false;

	public $appends = [
	    'email_u_r_i',
        'profile_image_u_r_l'
    ];

	public function departmentUser()
    {
		return $this->hasMany('App\Models\DepartmentUser', 'user_id', 'individuals_id');
	}

	public function entityUser()
    {
		return $this->hasMany('App\Models\EntityUser', 'user_id', 'individuals_id');
	}

	public function image()
    {
		return $this->hasOne('App\Models\Image', 'imageable_id', 'individuals_id');
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
            return url('uploads/imgs/' . $this->emailURI .
                '/' . $this->image->src);
        }
        return url('imgs/profile-default.png');
    }

}