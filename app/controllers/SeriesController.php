<?php

class SeriesController extends BaseController
{

  public function create()
  {
    $new = Input::all();
    $series = new Series;

    if ($series->validate($new)) {
      $series->name = Input::get('name');
      $series->version = Input::get('version');
      $series->author = Input::get('author');
      $pub_on_db = Publisher::where('name','=',Input::get('publisher'))->get();
      if (count($pub_on_db) == 0) {
        $publisher = new Publisher;
        $publisher->name = Input::get('publisher');
        $publisher->save();
        $series->publisher_id = $publisher->id;
      }else {
        foreach($pub_on_db as $publisher){
          $series->publisher_id = $publisher->id;
        }
      }
//      $series->publisher;
//      if (Input::get('type_id') != null)
//        $series->type_id = Input::get('type_id');
//      if (Input::get('subtype_id') != null)
//        $series->subtype_id = Input::get('subtype_id');
      $series->save();
      return Redirect::to('series/' . $series->id);
    } else {
      $errors = $series->errors();
      return Redirect::to('series/' . $series->id)->withErrors($errors);
    }
  }

  public function update()
  {
    $new = Input::all();
    $id = Input::get('id');
    $series = Series::find($id);
    if ($series->validate($new)) {
      $series->name = Input::get('name');
      $series->version = Input::get('version');
      $series->author = Input::get('author');
      $publisher = $series->publisher;
      $publisher->name = Input::get('publisher');
      $concluded = Input::get('concluded');
      if ($concluded != $series->concluded)
        $series->concluded = $concluded;
////    if (Input::get('type_id') != null)
////      $series->type_id = Input::get('type_id');
////    if (Input::get('subtype_id') != null)
////      $series->subtype_id = Input::get('subtype_id');
      $series->update();
      $publisher->update();
      return Redirect::to('series/' . $id);
    } else {
      $errors = $series->errors();
      return Redirect::to('series/' . $id)->withErrors($errors);
    }
  }

  public function delete()
  {
    // first level logic deletion
    $series_id = Input::get('id');
    $path = Input::get('return');
    $rules = array('id' => 'required|numeric|exists:bm_series,id,active,1');
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Redirect::to($path)->withErrors($validator);
    } else {
      $series = Series::find($series_id);
      $series->active = 0;
      $series->update();
      $comics = $series->listComics;
      $this->deleteComics($comics);
      $this->deleteSeriesUser($series_id);
      return Redirect::to($path);
    }
  }

  public function delete2()
  {
    // second level logic deletion
    $series_id = Input::get('id');
    $path = Input::get('return');
    $rules = array('id' => 'required|numeric|exists:bm_series,id,active,1');
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Redirect::to($path)->withErrors($validator);
    } else {
      $series = Series::find($series_id);
      $series->active = 2;
      $series->update();
      $comics = $series->listComics;
      $this->deleteComics2($comics);
      $this->deleteSeriesUser2($series_id);
      return Redirect::to('series');
    }
  }

  public function restore()
  {
    $series_id = Input::get('id');
    $path = Input::get('return');
    $rules = array('id' => 'required|numeric|exists:bm_series,id,active,0');
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Redirect::to($path)->withErrors($validator);
    } else {
      $series = Series::find($series_id);
      $series->active = 1;
      $series->update();
      if (Input::get('comics') == 1) {
        DB::table('bm_comics')->where('series_id', $series_id)->update(array('active' => 1));
      }
      return Redirect::to($path);
    }
  }

  public function deleteComics($comics)
  {
    foreach ($comics as $comic) {
      DB::table('bm_comic_user')->where('comic_id', $comic->id)->update(array('active' => 0));
      $comic->active = 0;
      $comic->update();
    }
  }

  public function deleteSeriesUser($series_id)
  {
    DB::table('bm_series_user')->where('series_id', $series_id)->update(array('active' => 0));
    // $seriesUser = SeriesUser::where('series_id',$series_id)->get();
    // foreach ($seriesUser as $box) {
    // $box -> active = 0;
    // $box -> update();
    // }
  }

  public function deleteComics2($comics)
  {
    foreach ($comics as $comic) {
      DB::table('bm_comic_user')->where('comic_id', $comic->id)->update(array('active' => 2));
      $comic->active = 2;
      $comic->update();
    }
  }

  public function deleteSeriesUser2($series_id)
  {
    DB::table('bm_series_user')->where('series_id', $series_id)->update(array('active' => 2));
    // $seriesUser = SeriesUser::where('series_id',$series_id)->get();
    // foreach ($seriesUser as $box) {
    // $box -> active = 0;
    // $box -> update();
    // }
  }

  // public function deleteComicUser($comics) {
  // foreach ($comics as $comic) {
  // DB::table('comic_user') -> where('comic_id', $comic->id) -> update(array('active' => 0));
  // }
  // }

  // public function restoreComics($comics) {
  // foreach ($comics as $comic) {
  // $comic -> active = 1;
  // $comic -> update();
  // }
  // }

}

?>