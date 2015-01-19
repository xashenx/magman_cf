<?php
class UserController extends BaseController {

	/**
	 * Show the page for the addiction of a series.
	 */
	public function box() {
		$series = SeriesUser::whereRaw('active = 1 and user_id =' . Auth::id())->get();
		$comics = ComicUser::whereRaw('state_id < 3 and active = 1 and user_id = ' . Auth::id())->get();
		$user = User::find(Auth::id());
		$due = $this->due($user);
		$this -> layout -> content = View::make('user/box', array('series' => $series,'user' => $user,'due' => $due,'comics' => $comics));
	}

	/*
	 * Displays the home page for an user of the platform
	 */
	public function userHome() {
		$one_week_earlier = date('Y-m-d',strtotime('-1 week'));
		$news = Comic::whereRaw("active = 1 and created_at > '" . $one_week_earlier . "'")->get();
		$comics = ComicUser::whereRaw('state_id < 3 and active = 1 and user_id = ' . Auth::id())->get();
		$user = User::find(Auth::id());
		$due = $this->due($user);
		$this -> layout -> content = View::make('user/homePage',array('news' => $news,'user' => $user,'due' => $due,'comics' => $comics));
	}

	public function userProfile(){
		if(Input::get('old_pass') != null)
			echo "ciao";
		else
		$this -> layout -> content = View::make('user/profilePage',array('user' => Auth::user()));
	}

	public function due($user){
		$due = 0;
		$discount = $user->discount;
		foreach ($user->listComics()->whereRaw('state_id < 3 and active = 1')->get() as $comic) {
			if($comic->comic->available > 0)
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

	public function viewSeries($series_id) {
		$series = Series::find($series_id);
		$comics = Comic::whereRaw('active = 1 and series_id = ' . $series_id) -> get();
		if ($series != null && $series -> active)
			$this -> layout -> content = View::make('user/viewSeries',
			 array('series' => $series,'comics' => $comics));
		else
			return Redirect::to('series');
	}

	public function contactTheShop(){
		$this -> layout -> content = View::make('user/contactTheShop');
	}
}
?>