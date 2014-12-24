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
		return View::make('admin/manageSeries');
	}

	/*
	 * Displays the boxes managment page
	 */
	public function manageBoxes() {
		return View::make('admin/manageBoxes');
	}
}
?>