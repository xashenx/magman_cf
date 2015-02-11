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
	protected $table = 'bm_users';

	protected $fillable = array('password', 'name', 'surname', 'number', 'discount', 'active');
	protected $guarded = array('id','remember_token','level_id');
	private $rules = array(
		'username' => 'required|email',
		'password' => 'required|regex:/^[0-9a-zA-Z\!\_\-\#]*$/|min:7',
		'name'  => 'required|alpha',
		'surname'  => 'required|alpha',
		'number' => 'required|numeric',
		'show_price' => 'regex:/^[0,1]$/',
		'active' => 'regex:/^[0,1]$/'
	);
	private $errors;

	public function validate($data){
		$v = Validator::make($data,$this->rules);
		if($v->fails()){
			$this->errors = $v->errors();
			return false;
		}
		return $v->passes();
	}

	public function errors(){
		return $this->errors;
	}
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
	
	public function listVouchers() {
		return $this -> hasMany('Voucher', 'user_id', 'id');
	}

	public function level() {
		// return $this->hasOne('Level', 'id', 'level_id'); // this matches the Eloquent model
		return $this -> hasOne('Level', 'id', 'level_id');
		// this matches the Eloquent model
	}

	public static function newUser($user, $password, $name, $surname, $number, $level, $discount){
		$new = new User;
		$new->username = $user;
		$new->password = $password;
		$new->name = $name;
		$new->surname = $surname;
		$new->number = $number;
		$new->level_id = $level;
		$new->discount = $discount;
		$new->save();
	}
	
	public function availableComics(){
		return $this->listComics()->whereRaw('state_id < 3');
	}

	public function availableVouchers(){
		return $this->listVouchers()->whereRaw('active = 1');
	}

	public function lastBuy(){
		$comic = $this->listComics()->where('state_id','=','3');
		return $comic;
	}
}
