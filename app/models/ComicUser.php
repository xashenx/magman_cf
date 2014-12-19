<?php

class ComicUser extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'comic_user';

  public function User() {
    return $this->hasMany('User'); // this matches the Eloquent model
  }

  public function Comic() {
    return $this->hasMany('Comic'); // this matches the Eloquent model
  }
}
?>