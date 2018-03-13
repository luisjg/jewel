<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'faculty.entity_user';

	/**
	 * Primary key in the table relationship.
	 *
	 * @var string
	 */
	protected $primaryKey = 'parent_entities_id';


	public $incrementing = false;

}