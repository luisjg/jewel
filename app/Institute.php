<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model {
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

}