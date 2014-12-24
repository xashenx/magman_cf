<?php
class UserController extends BaseController {
	protected $layout = 'layouts.master';
	/**
	 * Show the page for the addiction of a series.
	 */
	public function box() {
		// $series = Series::all()->listComics->where('useri');
		$series = SeriesUser::where('user_id','=',Auth::id())->get();
		// $comics = ComicUser::where('user_id','=',Auth::id())->get();
		// $comics = ComicUser::where('user_id','=',Auth::id())->get();
		$comics = ComicUser::whereRaw('state_id < 3 and user_id = ' . Auth::id())->get();
		// $comics = $comics->where('state_id','<','3')->get();
		$user = User::find(Auth::id());
		// ->where('state_id','=','1')->get();
		// ->where('user_id','=','1');
		// $series = Series::all();
		$due = $this->due($user);
		$this -> layout -> content = View::make('user/box', array('series' => $series,'user' => $user,'due' => $due,'comics' => $comics));
		// return View::make('user/box');
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
	
	public function due($user){
		$due = 0;
		$discount = $user->discount;
		foreach ($user->listComics as $comic) {
			if($comic->comic->available > 1 and $comic->state_id < 3)
				$due += round($comic->price,2);
		}
		return $due-($due*$discount/100);
	}
	
}
?>