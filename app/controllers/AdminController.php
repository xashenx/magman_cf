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
		return View::make('admin/addBox');
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