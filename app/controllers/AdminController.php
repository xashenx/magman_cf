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

	/*
	 * Displays the boxes managment page
	 */
	public function manageBoxes() {
		// User::newUser('fabrizio@magman.it', Hash::make('fabrizio'),'Fabrizio','Zeni','3','2','45');
		$boxes = User::all();
		// return View::make('admin/manageBoxes');
		$this -> layout -> content = View::make('admin/manageBoxes', array('boxes' => $boxes));
	}

}
?>