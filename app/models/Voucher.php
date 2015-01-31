<?php

class Voucher extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'bm_vouchers';
  private $rules = array(
      'user_id' => 'required|numeric',
      'description'  => "regex:/^[A-z 'àèìòù]*$/",
      'amount' => 'required|regex:/^[0-9]{1,8}[\.\,]?[0-9]{0,2}$/',
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

  public function series() {
    return $this->hasOne('Series', 'id', 'series_id'); // this matches the Eloquent model
  }

  public function comic_user() {
    return $this->belongsTo('ComicUser');
  }

}
?>