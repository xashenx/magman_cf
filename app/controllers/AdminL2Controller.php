<?php
class AdminL2Controller extends BaseController {
	protected $layout = 'layouts.master_level2';
	
	public function manageSerie($series_id) {
		$series = Series::find($series_id);
		// $comic = Comic::get(1);
		$this -> layout -> content = View::make('admin/viewSeries', array('series' => $series));
	}
	
	public function manageComic($series_id,$comic_id) {
		echo $series_id . $comic_id;
		$this -> layout -> content = View::make('admin/homePage');
	}

	/*
	 * Displays the box managment page
	 */
	public function manageBox($id) {
		// User::newUser('fabrizio@magman.it', Hash::make('fabrizio'),'Fabrizio','Zeni','3','2','45');
		// $boxes = User::all();
		// $available = $this->buildAvailableArray($boxes);
		// $due = $this->buildDueArray($boxes);
		// return View::make('admin/manageBoxes');
		echo $id;
		$this -> layout -> content = View::make('admin/homePage');
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

}
?>