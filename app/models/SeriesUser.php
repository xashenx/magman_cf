<?php

class SeriesUser extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'series_user';

  public function user() {
    return $this->hasMany('User'); // this matches the Eloquent model
  }

  public function series() {
    return $this->hasMany('Series', 'id', 'series_id'); // this matches the Eloquent model
  }

}
?>