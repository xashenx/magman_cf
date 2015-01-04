<?php

class ComicUser extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comic_user';
	
	protected $guarded = array('id','remember_token','level_id');

	public function user() {
		return $this -> hasMany('User');
		// this matches the Eloquent model
	}

	public function comic() {
		return $this -> hasOne('Comic', 'id', 'comic_id');
		// this matches the Eloquent model
	}
	
	public function series(){
		return $this->comic->series();
	}
	
	public function box() {
		return $this -> hasOne('User', 'id', 'user_id');
		// this matches the Eloquent model
	}
}
?>