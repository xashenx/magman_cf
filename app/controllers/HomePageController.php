<?php
class HomePageController extends BaseController {

	/**
	 * Show the profile for the given user.
	 */
	protected $layout = 'layouts.master';
	public function index() {
		$comic = ComicUser::find(1) -> comic -> series;
		//$comic = Comic::where('name', 'LIKE', '%città%')
		// ->get();
		$this -> layout -> content = View::make('homePage', array('comic' => $comic));
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
		$this -> layout -> content = View::make('admin/adminHomePage');
	}

	/*
	 * Displays the home page for an user of the platform
	 */
	public function userHome() {
		$comic = ComicUser::find(2) -> comic;
		//$comic = Comic::where('name', 'LIKE', '%città%')
		// ->get();
		$this -> layout -> content = View::make('user/userHomePage', array('comic' => $comic));
	}

}
?>