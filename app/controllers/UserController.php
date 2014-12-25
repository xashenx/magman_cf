<?php
class UserController extends BaseController {
	protected $layout = 'layouts.master';
	
	/**
	 * Show the page for the addiction of a series.
	 */
	public function box() {
		// $series = Series::all()->listComics->where('useri');
		$series = SeriesUser::whereRaw('active = 1 and user_id =' . Auth::id())->get();
		// $comics = ComicUser::where('user_id','=',Auth::id())->get();
		// $comics = ComicUser::where('user_id','=',Auth::id())->get();
		$comics = ComicUser::whereRaw('state_id < 3 and active = 1 and user_id = ' . Auth::id())->get();
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
		$this -> layout -> content = View::make('user/homePage');
	}
	
	public function due($user){
		$due = 0;
		$discount = $user->discount; 
		foreach ($user->listComics()->whereRaw('state_id < 3 and active = 1')->get() as $comic) {
			if($comic->comic->available > 1)
				$due += round($comic->price,2);
		}
		return $due-($due*$discount/100);
	}	
	
	/*
	 * Displays the series page
	 */
	public function listSeries() {
		$series = Series::where('active','=','1')->get();
		$this -> layout -> content = View::make('user/listSeries', array('series' => $series));
	}
}
?>