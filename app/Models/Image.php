<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
	protected $table = 'faculty.images';	
	protected $fillable = ['imageable_id', 'imageable_type', 'src'];
}
