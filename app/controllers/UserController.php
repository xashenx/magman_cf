<?php
class UserController extends BaseController {

	/**
	 * Show the page for the addiction of a series.
	 */
	public function box() {
		return View::make('user/box');
	}

	/*
	 * Displays the home page for an user of the platform
	 */
	public function userHome() {
		$comic = ComicUser::find(2) -> comic;
		//$comic = Comic::where('name', 'LIKE', '%città%')
		// ->get();
		return View::make('user/homePage', array('comic' => $comic));
	}

}
?>