<?php

class ComicUserController extends BaseController
{

  public function create()
  {
    $this->layout = null;
    $series_id = Input::get('single_series_id');
    $series = Series::find($series_id);
    $complete_series = Input::get('complete_series');
    if (count($series) > 0) {
      $comics_of_series = $series->listActive;
      $user_id = Input::get('user_id');
      if ($complete_series) {
        // insertion of the complete series
        foreach ($comics_of_series as $comic) {
          $comicUser = new ComicUser;
          $comicUser->comic_id = $comic->id;
          $comicUser->user_id = $user_id;
          $comicUser->price = $comic->price;
          $comicUser->save();
        }
        return Redirect::to('boxes/' . $user_id);
      } else {
        // insertion of a single comic
        $comic_number = Input::get('single_number_value');
        $comic = DB::select('SELECT * FROM bm_comics WHERE active = 1 AND number = \'' . $comic_number . '\' AND series_id = \'' . $series_id . '\'');
        if (count($comic) == 0) {
          // need to create the comic
          $last_comic = null;
          if (count($comics_of_series) > 0) {
            $last_comic = Comic::find($comics_of_series->max('id'));
            $last_comic->price = round($last_comic->price, 2);
          }
          if ($last_comic->number > $comic_number) {
            $new_comic = new Comic;
            $new_comic->series_id = $series_id;
            $new_comic->number = $comic_number;
            $new_comic->price = $last_comic->price;
            $new_comic->state = 2;
            $new_comic->arrived_at = date('Y-m-d H:i:s', strtotime('-2 week'));
            $new_comic->save();
          } else {
            //TODO HANDLE ERROR (IT SHOULD BE ALREADY HANDLED BY JS VALIDATION)
          }
        }
//      $comics = $series->listActive()->where('id', '=', $comic_id)->get();
        $comics = $series->listActive()->where('number', '=', $comic_number)->get();
        if (count($comics) > 1) {
          //TODO warning, no more than one number for series should be present!
        } else {
          foreach ($comics as $comic) {
            $comic_id = $comic->id;
            Input::merge(array('comic_id' => $comic_id));
            Input::merge(array('price' => $comic->price));
            $new = Input::all();
            $comicUser = new ComicUser;
            if ($comicUser->validate($new)) {
              $comicUser->comic_id = $comic_id;
              $comicUser->user_id = $user_id;
              $comicUser->price = $comic->price;
              $comicUser->save();
            } else {
              $errors = $comic->errors();
              return Redirect::to('boxes/' . $user_id)->withErrors($errors);
            }
          }
        }
      }
    }
    return Redirect::to('boxes/' . $user_id);
  }

  public function update()
  {
    $cu_id = Input::get('cu_id');
    $u_id = Input::get('user_id');
    $comicUser = ComicUser::find($cu_id);
    $comicUser->price = Input::get('price');
    /*if (Input::get('active'))
      $comicUser -> active = 1;
    else
      $comicUser -> active = 0;*/
    $comicUser->update();
    return Redirect::to('boxes/' . $u_id);
  }

  public function delete()
  {
    $id = Input::get('id');
    $user_id = Input::get('user_id');
    $comics = ComicUser::whereRaw('id = ' . $id . ' and user_id = ' . $user_id)->get();
    foreach ($comics as $comic) {
      $comic->active = '0';
      $comic->update();
    }
    return Redirect::to('boxes/' . $user_id);
  }

  public function buy()
  {
    $id = Input::get('id');
    $user_id = Input::get('user_id');
    $comics = ComicUser::whereRaw('id = ' . $id . ' and user_id = ' . $user_id)->get();
    foreach ($comics as $comicUser) {
      $timestamp = date("Y-m-d H:i:s", time());
      $comicUser->buy_time = $timestamp;
      $comicUser->state_id = 3;
      $comic = $comicUser->comic;
      $comic->available -= 1;
      $comicUser->update();
      $comic->update();
    }
    return Redirect::to('boxes/' . $user_id);
  }

}

?>