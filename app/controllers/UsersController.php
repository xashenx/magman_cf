<?php
class UsersController extends BaseController {
	protected $layout = 'layouts.master_level2';

	/*
	 * Displays the box managment page
	 */
	public function manageBox($box_id) {
		$user = User::find($box_id);
		$series = SeriesUser::where('user_id', '=', $box_id) -> get();
		$comics = ComicUser::whereRaw('state_id < 3 and active = 1 and user_id = ' . $box_id) -> get();
		$due = $this -> due($user);
		if ($user != null)
			$this -> layout -> content = View::make('admin/viewBox', array('user' => $user, 'comics' => $comics, 'due' => $due, 'series' => $series));
		else
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

	public function createUser() {
		$user = new User;
		$user -> username = Input::get('username');
		$user -> password = Hash::make(Input::get('password'));
		$user -> name = Input::get('name');
		$user -> surname = Input::get('surname');
		$user -> number = Input::get('number');
		$user -> discount = Input::get('discount');
		$user -> save();
		return Redirect::to('boxes/' . $user->id);
	}

	public function updateUser() {
		$id = Input::get('id');
		$user = User::find($id);
		$user -> name = Input::get('name');
		$user -> surname = Input::get('surname');
		$user -> number = Input::get('number');
		$user -> password = Hash::make(Input::get('pass'));
		$user -> discount = Input::get('discount');
		if (Input::get('active'))
			$user -> active = 1;
		else
			$user -> active = 0;
		$user -> save();
		return Redirect::to('boxes/' . $id);
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