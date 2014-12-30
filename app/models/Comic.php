<?php

class Comic extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'comics';

  public function series() {
    return $this->hasOne('Series', 'id', 'series_id'); // this matches the Eloquent model
  }

  public function comic_user() {
    return $this->belongsTo('ComicUser');
  }

}
?>