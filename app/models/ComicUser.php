<?php

class ComicUser extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'comic_user';

  public function user() {
    return $this->hasMany('User'); // this matches the Eloquent model
  }

  public function comic() {
    return $this->hasOne('Comic', 'id', 'comic_id'); // this matches the Eloquent model
  }
}
?>