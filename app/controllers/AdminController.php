<?php
class AdminController extends BaseController {
	protected $layout = 'layouts.master';
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
		return View::make('admin/addBox');
	}

	/*
	 * Displays the series managment page
	 */
	public function manageSeries() {
		// return View::make('admin/manageSeries');
		$series = Series::all();
		$this -> layout -> content = View::make('admin/manageSeries', array('series' => $series));
	}

	public function updateSeries($series){
		
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
	
	// public function buildBoxesArrays($boxes){
		// $return_array= $available = $due = null;
		// foreach ($boxes as $box) {
			// // check available comics and due
			// $comics = $box->listComics()->whereRaw('state_id < 3')->get();
			// $available_counter = $due_counter = 0;
			// foreach ($comics as $comic) {
				// if ($comic -> comic -> available > 1) {
					// $available_counter++;
					// $due_counter += round($comic->price,2);
				// }
			// }
			// $due_counter = $due_counter-($due_counter*$box->discount/100);
			// $available = array_add($available, $box -> id,$available_counter);
			// $due = array_add($due, $box -> id,$due_counter);
		// }
		// $return_array = array_add($return_array,$available,'available');
		// $return_array = array_add($return_array,$due,'due');
		// return $return_array;
	// }

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