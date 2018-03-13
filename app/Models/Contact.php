<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	protected $table='fresco.contacts';
    protected $primaryKey = 'contact_id';

    /**
     * Relates this Contact to its associated Person model.
     *
     * @return Builder
     */
	public function person() {
        return $this->belongsTo('App\Models\Person', 'entities_id', 'individuals_id');
    }

    /**
     * Relates this Contact to its associated ConnectableEntity model.
     *
     * @return Builder
     */
    public function contactDepartment() {
        return $this->belongsTo('App\Models\ConnectableEntity','parent_entities_id','connectable_id');
    }

    /**
     * Returns the associated telephone number or the string 'Not Available' if
     * it could not be resolved.
     *
     * @return string
     */
    public function getTelephoneAttribute() {
    	if (!property_exists($this, 'telephone')) {
	        return 'Not Available';
    	}
    	return $this->telephone;
    }

}