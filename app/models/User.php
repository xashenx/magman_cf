<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	// protected $fillable = array('password', 'name', 'surname', 'number', 'level_id', 'discount', 'active');
	protected $fillable = array('name');
	protected $guarded = array();

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	public function series_user() {
		return $this -> belongsTo('SeriesUser');
	}

	public function comic_user() {
		return $this -> belongsTo('ComicUser');
	}

	public function listSeries() {
		return $this -> hasMany('SeriesUser', 'user_id', 'id');
	}
	
	public function listComics() {
		return $this -> hasMany('ComicUser', 'user_id', 'id');
	}

	public function level() {
		// return $this->hasOne('Level', 'id', 'level_id'); // this matches the Eloquent model
		return $this -> hasOne('Level', 'id', 'level_id');
		// this matches the Eloquent model
	}

}
