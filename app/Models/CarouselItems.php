<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselItems extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'homepage_carousel';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;

}
