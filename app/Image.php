<?php namespace Jewel;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
	protected $table = 'faculty.images';	
	protected $fillable = ['imageable_id', 'imageable_type', 'src'];
}
