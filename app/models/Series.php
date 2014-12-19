<?php

class Series extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'series';

  public function comic() {
    return $this->belongsTo('Comic');
  }

  public function series_user() {
    return $this->belongsTo('SeriesUser');
  }


}
?>