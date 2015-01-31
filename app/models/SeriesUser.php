<?php

class SeriesUser extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bm_series_user';
	private $rules = array(
		'series_id' => 'required|numeric',
		'user_id' => 'required|numeric'
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

	public function user() {
		return $this -> hasMany('User');
		// this matches the Eloquent model
	}

	public function series() {
		return $this -> hasOne('Series', 'id', 'series_id');
		// this matches the Eloquent model
	}

}
?>