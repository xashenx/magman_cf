<?php

class Series extends Eloquent
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'bm_series';
  private $rules = array(
    'name' => 'required|regex:/^[A-z 0-9\'àèìòù&,\.\?\!()\$\€%"£^\@\n\+\-]*$/',
    'version' => 'regex:/^[A-z 0-9\'àèìòù&,\.\?\!()\$\€%"£^\@\n\+\-]*$/',
    'author' => 'required|regex:/^[A-z 0-9\'àèìòù&,\.\?\!()\$\€%"£^\@\n\+\-]*$/',
    'publisher' => 'required|regex:/^[A-z 0-9\'àèìòù&,\.\?\!()\$\€%"£^\@\n\+\-]*$/',
    'active' => 'regex:/^[0,1]$/',
    'concluded' => 'regex:/^[0,1]$/',
  );
  private $errors;

  public function validate($data)
  {
    $v = Validator::make($data, $this->rules);
    if ($v->fails()) {
      $this->errors = $v->errors();
      return false;
    }
    return $v->passes();
  }

  public function errors()
  {
    return $this->errors;
  }

  public function comic()
  {
    return $this->belongsTo('Comic', 'id', 'series_id');
  }

  public function series_user()
  {
    return $this->belongsTo('SeriesUser', 'id', 'series_id');
  }

  public function listComics()
  {
    return $this->hasMany('Comic', 'series_id', 'id');
    // this matches the Eloquent model
  }

  public function listActive()
  {
    return $this->hasMany('Comic')->where('active', '=', '1');
  }

  public function inBoxes()
  {
    // return $this -> hasMany('SeriesUser', 'series_id', 'id');
    return $this->hasMany('SeriesUser')->where('active', '=', '1');
    // this matches the Eloquent model
  }

}

?>