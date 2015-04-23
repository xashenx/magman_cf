<?php

class ComicUserController extends BaseController
{

  public function create()
  {
    $this->layout = null;
    $series_id = Input::get('single_series_id');
    $series = Series::find($series_id);
    $mode = Input::get('mode');
    if (count($series) > 0) {
//      $comics_of_series = $series->listActive->get();
//      if ($mode == 2)
//        $comics_of_series = Comic::whereRaw('series_id = ' . $series_id . ' AND active = 1 AND number >= ' . Input::get('block_from') . ' AND number <= ' . Input::get('block_to'))->orderBy('number', 'asc')->get();
//      else
      $comics_of_series = Comic::whereRaw('series_id = ' . $series_id . ' AND active = 1')->orderBy('number', 'asc')->get();
      $user_id = Input::get('user_id');

      if ($mode == 1 || $mode == 2) {
        // insertion of the complete series

        $seriesUser = SeriesUser::whereRaw('user_id = ' . $user_id . ' AND series_id = ' . $series_id)->get();
        if ($series->completed != 1 && count($seriesUser) == 0) {
          $new_series_user = new SeriesUser();
          $new_series_user->series_id = $series_id;
          $new_series_user->user_id = $user_id;
          $new_series_user->save();
        } else if (count($seriesUser) > 0) {
          foreach ($seriesUser as $su) {
            $su->active = 1;
            $su->update();
          }
        }
        if ($mode == 2) {
          $comics_counter = Input::get('block_from');
        } else {
          $comics_counter = 1;
        }
        foreach ($comics_of_series as $comic) {
          if ($mode == 2 && $comic->number > Input::get('block_to') && $comics_counter < Input::get('block_to')) {
            echo "sono qua! " . $comics_counter . '|' . $comic->number . '|' . Input::get('block_to');
            while ($comics_counter < Input::get('block_to') + 1) {
              $new_comic = new Comic;
              $new_comic->series_id = $series_id;
              $new_comic->number = $comics_counter++;
              $new_comic->price = $comic->price;
              $new_comic->state = 2;
              $new_comic->arrived_at = date('Y-m-d H:i:s', strtotime('-2 week'));
              $new_comic->save();

              $comicUser = new ComicUser;
              $comicUser->comic_id = $new_comic->id;
              $comicUser->user_id = $user_id;
              $comicUser->price = $comic->price;
              $comicUser->old_comic = 1;
              $comicUser->old_series = 1;
              $comicUser->discount = Input::get('series_discount');
              $comicUser->save();
            }
          } else if ($mode == 1 || ($mode == 2 && $comic->number < Input::get('block_to') && $comic->number > Input::get('block_from'))) {
            while ($comics_counter < $comic->number) {
              $new_comic = new Comic;
              $new_comic->series_id = $series_id;
              $new_comic->number = $comics_counter++;
              $new_comic->price = $comic->price;
              $new_comic->state = 2;
              $new_comic->arrived_at = date('Y-m-d H:i:s', strtotime('-2 week'));
              $new_comic->save();

              $comicUser = new ComicUser;
              $comicUser->comic_id = $new_comic->id;
              $comicUser->user_id = $user_id;
              $comicUser->price = $comic->price;
              $comicUser->old_comic = 1;
              $comicUser->old_series = 1;
              $comicUser->discount = Input::get('series_discount');
              $comicUser->save();
            }
            $comicUser = new ComicUser;
            $comicUser->comic_id = $comic->id;
            $comicUser->user_id = $user_id;
            $comicUser->price = $comic->price;
            $comicUser->old_comic = 1;
            $comicUser->old_series = 1;
            $comicUser->discount = Input::get('series_discount');
            $comicUser->save();
            $comics_counter++;
          }

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
        $comicUser = new ComicUser;
        if (count($comics) > 1) {
          //TODO warning, no more than one number for series should be present!
        } else {
          foreach ($comics as $comic) {
            $comic_id = $comic->id;
            Input::merge(array('comic_id' => $comic_id));
            Input::merge(array('price' => $comic->price));
            $new = Input::all();
            if ($comicUser->validate($new)) {
              if (Input::get('old_comic') == 'yes')
                $comicUser->old_comic = 1;
              $comicUser->comic_id = $comic_id;
              $comicUser->user_id = $user_id;
              $comicUser->price = $comic->price;
              $comicUser->discount = Input::get('discount');
              $comicUser->save();
            } else {
              $errors = $comic->errors();
              return Redirect::to('boxes/' . $user_id)->withErrors($errors);
            }
          }
        }
      }
    }
    return Redirect::to('boxes/' . $user_id . '/comic/' . $comicUser->id);
  }

  public function update()
  {
    $cu_id = Input::get('cu_id');
    $u_id = Input::get('user_id');
    $comicUser = ComicUser::find($cu_id);
    $comicUser->price = Input::get('price');
    $comicUser->discount = Input::get('discount');
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

  public function buyOldSeries()
  {
    $id = Input::get('id');
    $user_id = Input::get('user_id');
    $comicUser = ComicUser::find($id);
    $buy_time = date("Y-m-d H:i:s", time());
    $series_id = $comicUser->comic->series_id;
    DB::update('UPDATE bm_comic_user cu LEFT JOIN bm_comics c ON cu.comic_id = c.id
              SET buy_time = \'' . $buy_time . '\', cu.state_id = 3
               WHERE cu.user_id = ' . $user_id . ' AND cu.old_series = 1 AND cu.state_id = 1 AND cu.active = 1 AND c.series_id = ' . $series_id);
    return Redirect::to('boxes/' . $user_id);
  }

  public function oldComicArrived()
  {
    $id = Input::get('id');
    $user_id = Input::get('user_id');
    $comicUser = ComicUser::find($id);
    $comicUser->old_arrived_at = date("Y-m-d H:i:s", time());
    $comicUser->update();
    return Redirect::to('boxes/' . $user_id);
  }

  public function oldSeriesArrived()
  {
    $id = Input::get('id');
    $user_id = Input::get('user_id');
    $comicUser = ComicUser::find($id);
    $arrived_at = date("Y-m-d H:i:s", time());
    $series_id = $comicUser->comic->series_id;
    DB::update('UPDATE bm_comic_user cu LEFT JOIN bm_comics c ON cu.comic_id = c.id
              SET old_arrived_at = \'' . $arrived_at . '\'
               WHERE cu.user_id = ' . $user_id . ' AND cu.old_series = 1 AND cu.state_id = 1 AND cu.active = 1 AND cu.old_arrived_at IS NULL AND c.series_id = ' . $series_id);
    return Redirect::to('boxes/' . $user_id);
  }

}

?>