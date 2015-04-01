<?php

class ComicUser extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bm_comic_user';
	private $rules = array(
		'comic_id' => 'required|numeric',
		'user_id' => 'required|numeric',
		'price' => 'required|numeric',
		'discount' => 'required|numeric|between:5,100',
		'block_from' => 'numeric',
		'block_to' => 'numeric'
		//'series_discount' => 'numeric|digits_between:5,100'
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