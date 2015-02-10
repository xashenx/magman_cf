<?php

class Comic extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'bm_comics';
  private $rules = array(
      'series_id' => 'required|numeric',
      'number' => 'required|numeric',
      'name'  => "regex:/^[A-z 'àèìòù]*$/",
      'price' => 'required|regex:/^[0-9]{1,8}[\.\,]?[0-9]{0,2}$/',
      'available' => 'numeric',
      'image' => array('regex:/^http[s]?:\/\/[a-zA-Z0-9\_\-\%]+.[a-zA-Z0-9]+.[a-zA-Z0-9\_\-\%]+\/([a-zA-Z0-9\_\-\%]+\/)*[a-zA-Z0-9\_\%\-]+.(gif|jpg|png)$/')
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