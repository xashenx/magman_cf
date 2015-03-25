<?php

class AdminController extends BaseController
{
  public function saveBox()
  {
    $username = Input::get('username');
    $password = Input::get('password');
    $user = new User;
    $user->username = $username;
    $user->password = $password;
    $user->save();
    $this->layout->content = View::make('admin/saveBox', array('username' => $username, 'password' => $password));
  }

  /*
   * Displays the series managment page
   */
  public function manageSeries()
  {
    $series = Series::all();
    $this->layout->content = View::make('admin/manageSeries', array('series' => $series));
  }

  /*
   * Displays the boxes managment page
   */
  public function manageBoxes()
  {
    $boxes = User::all();
    $next_box_id = $boxes->max('number') + 1;
    $available = $this->buildAvailableArray($boxes);
    $due = $this->buildDueArray($boxes);
    $this->layout->content = View::make('admin/manageBoxes',
      array('boxes' => $boxes, 'available' => $available, 'due' => $due, 'next_box_id' => $next_box_id));
  }


  public function manageSerie($series_id)
  {
    $inv_state = $this->module_state('inventory');
    $series = Series::find($series_id);
    if ($series != null) {
      $comics = $series->listActive;
      $last_comic = null;
      if (count($comics) > 0) {
        $last_comic = Comic::find($comics->max('id'));
        $last_comic->price = round($last_comic->price, 2);
      }

      $this->layout->content = View::make('admin/viewSeries', array('series' => $series, 'last_comic' => $last_comic, 'inv_state' => $inv_state));
    } else
      return Redirect::to('series');
  }

  public function manageComic($series_id, $comic_id)
  {
    $inv_state = $this->module_state('inventory');
    $comic = Comic::find($comic_id);
    $comic->price = round($comic->price, 2);
    $ordered = ComicUser::whereRaw('active = 1 AND state_id = 1 AND comic_id = ' . $comic_id)->get();
    if ($comic != null && $comic->series->id == $series_id)
      $this->layout->content = View::make('admin/viewComic', array('comic' => $comic, 'path' => '../../', 'ordered' => $ordered, 'inv_state' => $inv_state));
    else
      return Redirect::to('series/' . $series_id);
  }

  /*
   * Displays the box managment page
   */
  public function manageBox($box_id)
  {
    $inv_state = $this->module_state('inventory');
    $user = User::find($box_id);
    $renewal_price = ShopConf::find(4)->value;
    if ($user != null) {
      $series = SeriesUser::where('user_id', '=', $box_id)->get();
//            $active_series = DB::select('SELECT s.id, s.name, s.version, count(*) as comics FROM bm_series as s LEFT JOIN bm_comics as c ON c.series_id = s.id WHERE s.active = 1 and c.active = 1 GROUP BY s.id');
      //$not_followed_series = DB::select('SELECT s.id, s.name, s.version FROM bm_series as s WHERE s.active = 1 AND s.id NOT IN (SELECT series_id FROM bm_series_user WHERE user_id = ' . $box_id . ')');
      $to_follow_series = DB::select('SELECT s.id, s.name, s.version FROM bm_series as s WHERE s.active = 1 ORDER BY s.name');
      $active_series = DB::select('SELECT s.id, s.name, s.version, count(*) as comics FROM bm_series as s LEFT JOIN bm_comics as c ON c.series_id = s.id WHERE s.active = 1 and c.active = 1 GROUP BY s.id ORDER BY s.name');
      $comics = ComicUser::whereRaw('state_id < 3 and active = 1 and user_id = ' . $box_id)->orderBy('id', 'asc')->get();
      $purchases = ComicUser::whereRaw('state_id = 3 and active = 1 and user_id = ' . $box_id)->get();
      $due = $this->due($user);
      $this->layout->content = View::make('admin/viewBox', array('user' => $user, 'comics' => $comics, 'due' => $due, 'series' => $series, 'purchases' => $purchases, 'active_series' => $active_series, 'to_follow_series' => $to_follow_series, 'renewal_price' => $renewal_price, 'inv_state' => $inv_state));
    } else
      return Redirect::to('boxes');
  }

  public function due($user)
  {
    $inv_state = $this->module_state('inventory');
    $due = 0;
    //$discount = $user->discount;
    foreach ($user->listComics()->whereRaw('state_id < 3 and active = 1')->get() as $comic) {
      if ($comic->comic->state == 2) {
        if (($comic->comic->available > 0 && $inv_state) || (!$inv_state && $comic->comic->state == 2 && (!$comic->old_comic || ($comic->old_arrived_at != NULL)))) {
          $price = round($comic->price, 2);
          $due += $price - ($price * $comic->discount / 100);
        }
        //$due += round($comic->price, 2);
      }
    }
    //return $due - ($due * $discount / 100);
    return $due;
  }

  public function buildAvailableArray($boxes)
  {
    $inv_state = $this->module_state('inventory');
    $available = null;
    foreach ($boxes as $box) {
      // check available comics and due
      $comics = $box->listComics()->whereRaw('state_id < 3 and active = 1')->get();
      $available_counter = 0;
      foreach ($comics as $comic) {
        if ($comic->comic->state == 2) {
          if (($comic->comic->available > 0 && $inv_state) || (!$inv_state && $comic->comic->state == 2 && (!$comic->old_comic || ($comic->old_arrived_at != NULL))))
            $available_counter++;
        }
      }
      $available = array_add($available, $box->id, $available_counter);
    }
    return $available;
  }

  public function buildDueArray($boxes)
  {
    $inv_state = $this->module_state('inventory');
    $due = null;
    foreach ($boxes as $box) {
      // check available comics and due
      $comics = $box->listComics()->whereRaw('state_id < 3 and active = 1')->get();
      $due_counter = 0;
      foreach ($comics as $comic) {
        if ($comic->comic->state == 2) {
          if (($comic->comic->available > 0 && $inv_state && (!$comic->old_comic || ($comic->old_arrived_at != NULL))) || (!$inv_state && $comic->comic->state == 2 && (!$comic->old_comic || ($comic->old_arrived_at != NULL)))) {
            $price = round($comic->price, 2);
            $due_counter += $price - ($price * $comic->discount / 100);
            //$due_counter += round($comic->price, 2);
          }
        }
      }
      //$due_counter = $due_counter - ($due_counter * $box->discount / 100);
      $due = array_add($due, $box->id, $due_counter);
    }
    return $due;
  }

  public function manageComicUser($box_id, $comic_user_id)
  {
    $comicUser = ComicUser::find($comic_user_id);
    // conditions of redirect: no comicUser,
    if ($comicUser == null || $comicUser->active == 0 || $comicUser->state_id == 3 || $comicUser->user_id != $box_id)
      return Redirect::to('boxes/' . $box_id);
    else
      $this->layout->content = View::make('admin/viewComicUser', array('comic' => $comicUser));
  }

  public function editVoucher($box_id, $voucher_id)
  {
    $voucher = Voucher::find($voucher_id);
    if ($voucher == null || $voucher->user_id != $box_id || $voucher->active == 0)
      return Redirect::to('boxes/' . $box_id);
    else
      $this->layout->content = View::make('admin/viewVoucher', array('voucher' => $voucher));
  }

  public function module_state($module_description)
  {
    $modules = Modules::where('description', '=', $module_description)->get();
    $state = 0;
    if (count($modules) == 1) {
      foreach ($modules as $module) {
        $state = $module->active;
      }
    }
    return $state;
  }

  public function shopSettings()
  {
    $this->layout->content = View::make('admin/shopSettings', array());
  }
}

?>
