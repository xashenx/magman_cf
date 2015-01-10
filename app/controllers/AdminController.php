<?php
class AdminController extends BaseController {
	/**
	 * Show the page for the addiction of a series.
	 */
	public function addSeries() {
		return View::make('admin/addSeries');
	}

	/**
	 * Show the page for the addiction of a comic.
	 */
	public function addComic() {
		return View::make('admin/addComic');
	}

	/**
	 * Show the page for the addiction of a box.
	 */
	public function addBox() {
		$this -> layout -> content = View::make('admin/addBox');
	}

	public function saveBox() {
		$username = Input::get('username');
		$password = Input::get('password');
		$user = new User;
		$user -> username = $username;
		$user -> password = $password;
		$user -> save();
		$this -> layout -> content = View::make('admin/saveBox', array('username' => $username, 'password' => $password));
	}

	/*
	 * Displays the series managment page
	 */
	public function manageSeries() {
		// return View::make('admin/manageSeries');
		$series = Series::all();
		$this -> layout -> content = View::make('admin/manageSeries', array('series' => $series));
	}

	/*
	 * Displays the boxes managment page
	 */
	public function manageBoxes() {
		// User::newUser('fabrizio@magman.it', Hash::make('fabrizio'),'Fabrizio','Zeni','3','2','45');
		$boxes = User::all();
		$next_box_id = $boxes->max('number')+1;
		$available = $this->buildAvailableArray($boxes);
		$due = $this->buildDueArray($boxes);
		// return View::make('admin/manageBoxes');
		$this -> layout -> content = View::make('admin/manageBoxes',
		 array('boxes' => $boxes,'available' => $available,'due' => $due, 'next_box_id' => $next_box_id));
	}


public function manageSerie($series_id) {
		$series = Series::find($series_id);
		$next_comic_number = $series -> listComics -> max('number') + 1;
		if ($series != null)
			$this -> layout -> content = View::make('admin/viewSeries', array('series' => $series, 'next_comic_number' => $next_comic_number));
		else
			return Redirect::to('series');
	}

	public function manageComic($series_id, $comic_id) {
		echo $series_id . $comic_id;
		$this -> layout -> content = View::make('admin/homePage');
	}

	/*
	 * Displays the box managment page
	 */
	public function manageBox($box_id) {
		$user = User::find($box_id);
		if ($user != null) {
			$series = SeriesUser::where('user_id', '=', $box_id) -> get();
			$active_series = DB::select('SELECT s.id, s.name, s.version, count(*) as comics FROM series as s LEFT JOIN comics as c ON c.series_id = s.id WHERE s.active = 1 and c.active = 1 GROUP BY s.id');
//			$active_series = Series::where('active','=',1)->get();
			$comics = ComicUser::whereRaw('state_id < 3 and active = 1 and user_id = ' . $box_id) -> get();
			$purchases = ComicUser::whereRaw('state_id = 3 and active = 1 and user_id = ' . $box_id) -> get();
			$due = $this -> due($user);
			$this -> layout -> content = View::make('admin/viewBox', array('user' => $user,'comics' => $comics,'due' => $due,'series' => $series,'purchases' => $purchases,'active_series' => $active_series));
		} else
			return Redirect::to('boxes');
	}

	public function due($user) {
		$due = 0;
		$discount = $user -> discount;
		foreach ($user->listComics()->whereRaw('state_id < 3 and active = 1')->get() as $comic) {
			if ($comic -> comic -> available > 1)
				$due += round($comic -> price, 2);
		}
		return $due - ($due * $discount / 100);
	}

	public function buildAvailableArray($boxes){
		$available = null;
		foreach ($boxes as $box) {
			// check available comics and due
			$comics = $box->listComics()->whereRaw('state_id < 3 and active = 1')->get();
			$available_counter = 0;
			foreach ($comics as $comic) {
				if ($comic -> comic -> available > 1) {
					$available_counter++;
				}
			}
			$available = array_add($available, $box -> id,$available_counter);
		}
		return $available;
	}

	public function buildDueArray($boxes) {
		$due = null;
		foreach ($boxes as $box) {
			// check available comics and due
			$comics = $box -> listComics() -> whereRaw('state_id < 3 and active = 1') -> get();
			$due_counter = 0;
			foreach ($comics as $comic) {
				if ($comic -> comic -> available > 1) {
					$due_counter += round($comic -> price, 2);
				}
			}
			$due_counter = $due_counter - ($due_counter * $box -> discount / 100);
			$due = array_add($due, $box -> id, $due_counter);
		}
		return $due;
	}

	public function manageComicUser($box_id, $comic_user_id) {
		$comicUser = ComicUser::find($comic_user_id);
		// conditions of redirect: no comicUser,
		if ($comicUser == null || $comicUser -> active == 0 || $comicUser -> state_id == 3 || $comicUser -> user_id != $box_id)
			return Redirect::to('boxes/' . $box_id);
		else
			$this -> layout -> content = View::make('admin/editComicUser', array('comic' => $comicUser));
	}
}
?>
