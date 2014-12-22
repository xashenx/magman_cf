<?php
class HomePageController extends BaseController {

	/**
	 * Show the profile for the given user.
	 */
	public function index() {
		$comic = ComicUser::find(1) -> comic;
		//$comic = Comic::where('name', 'LIKE', '%città%')
		// ->get();
		return View::make('homePage', array('comic' => $comic));
	}

	/*
	 * Displays the home page for an administrator of the platform
	 */
	public function adminHome() {
		// $comic = User::find(Auth::id);
		// // return View::make('homePage', array('comic' => $comic));
		// return View::make('homePage', array('comic' => $comic));
		// $comic = ComicUser::find(2) -> comic;
		//$comic = Comic::where('name', 'LIKE', '%città%')
		// ->get();
		// return View::make('admin/adminHomePage', array('comic' => $comic));
		// $user = Auth::user();
		return View::make('admin/adminHomePage');
	}

	/*
	 * Displays the home page for an user of the platform
	 */
	public function userHome() {
		$comic = ComicUser::find(2) -> comic;
		//$comic = Comic::where('name', 'LIKE', '%città%')
		// ->get();
		return View::make('user/userHomePage', array('comic' => $comic));
	}

}
?>