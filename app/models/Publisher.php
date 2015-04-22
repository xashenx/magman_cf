<?php

class Publisher extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'bm_publishers';
  private $rules = array(
      'name'  => "required|regex:/^[A-z 'àèìòù]*$/"
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
    return $this->hasMany('Series', 'publisher_id', 'id'); // this matches the Eloquent model
  }

}
?>