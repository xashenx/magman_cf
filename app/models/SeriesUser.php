<?php

class SeriesUser extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'series_user';

  public function User() {
    return $this->hasMany('User'); // this matches the Eloquent model
  }

  public function Series() {
    return $this->hasMany('Series'); // this matches the Eloquent model
  }

}
?>