<?php
class AdminL2Controller extends BaseController {
	protected $layout = 'layouts.master_level2';

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

	public function buildAvailableArray($boxes) {
		$available = null;
		foreach ($boxes as $box) {
			// check available comics and due
			$comics = $box -> listComics() -> whereRaw('state_id < 3') -> get();
			$available_counter = 0;
			foreach ($comics as $comic) {
				if ($comic -> comic -> available > 1) {
					$available_counter++;
				}
			}
			$available = array_add($available, $box -> id, $available_counter);
		}
		return $available;
	}

	public function buildDueArray($boxes) {
		$due = null;
		foreach ($boxes as $box) {
			// check available comics and due
			$comics = $box -> listComics() -> whereRaw('state_id < 3') -> get();
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

	public function due($user) {
		$due = 0;
		$discount = $user -> discount;
		foreach ($user->listComics()->whereRaw('state_id < 3 and active = 1')->get() as $comic) {
			if ($comic -> comic -> available > 1)
				$due += round($comic -> price, 2);
		}
		return $due - ($due * $discount / 100);
	}

}
?>