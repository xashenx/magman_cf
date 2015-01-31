<?php

class Modules extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bm_modules';
	
	protected $guarded = array('id','description');

}
?>