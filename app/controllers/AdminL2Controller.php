<?php
class AdminL2Controller extends BaseController {
	protected $layout = 'layouts.master_level2';
	
	public function manageSerie($series_id) {
		$series = Series::find($series_id);
		if($series != null)
			$this -> layout -> content = View::make('admin/viewSeries', array('series' => $series));
		else
			return Redirect::to('series');
	}
	
	public function manageComic($series_id,$comic_id) {
		echo $series_id . $comic_id;
		$this -> layout -> content = View::make('admin/homePage');
	}

	/*
	 * Displays the box managment page
	 */
	public function manageBox($box_id) {
		$user = User::find($box_id);
		if($user != null)
			$this -> layout -> content = View::make('admin/viewBox', array('user' => $user));
		else
			return Redirect::to('boxes');
	}

	public function buildAvailableArray($boxes){
		$available = null;
		foreach ($boxes as $box) {
			// check available comics and due
			$comics = $box->listComics()->whereRaw('state_id < 3')->get();
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
	
	public function buildDueArray($boxes){
		$due = null;
		foreach ($boxes as $box) {
			// check available comics and due
			$comics = $box->listComics()->whereRaw('state_id < 3')->get();
			$due_counter = 0;
			foreach ($comics as $comic) {
				if ($comic -> comic -> available > 1) {
					$due_counter += round($comic->price,2);
				}
			}
			$due_counter = $due_counter-($due_counter*$box->discount/100);
			$due = array_add($due, $box -> id,$due_counter);
		}
		return $due;
	}

	public function updateUser(){
		$id = Input::get('id');
		$user = User::find($id);
		$user->name = Input::get('name');
		$user->surname = Input::get('surname');
		$user->number = Input::get('number');
		$user->password = Input::get('password');
		$user->discount = Input::get('discount');
		if(Input::get('active'))
			$user->active = 1;
		else
			$user->active = 0;
		$user->save();
		return Redirect::to('boxes/' . $id);
	}
}
?>