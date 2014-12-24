<?php

class Series extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'series';

	public function comic() {
		return $this -> belongsTo('Comic', 'id', 'series_id');
	}

	public function series_user() {
		return $this -> belongsTo('SeriesUser', 'id', 'series_id');
	}

	public function listComics() {
		return $this -> hasMany('Comic', 'series_id', 'id');
		// this matches the Eloquent model
	}

	public function inBoxes() {
		// return $this -> hasMany('SeriesUser', 'series_id', 'id');
		return $this->hasMany('SeriesUser')->where('active','=','1');
		// this matches the Eloquent model
	}
	
}
?>