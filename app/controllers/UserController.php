<?php
class UserController extends BaseController {
	protected $layout = 'layouts.master';
	
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
		$last = Comic::where('active','=','1')->max('created_at');
		$last = date('Y-m-d',strtotime($last));
		$news = Comic::whereRaw("active = 1 and created_at > '" . $last . "'")->get();
		$comics = ComicUser::whereRaw('state_id < 3 and active = 1 and user_id = ' . Auth::id())->get();
		$user = User::find(Auth::id());
		$due = $this->due($user);
		$last = date('d-m-Y',strtotime($last));
		$this -> layout -> content = View::make('user/homePage',array('news' => $news,'user' => $user,'due' => $due,'comics' => $comics,'last' => $last));
	}

	public function userProfile(){
		echo "asdasda" . Input::get('old_pass');
		echo var_dump(Input::all());
		if(Input::get('old_pass') != null)
			echo "ciao";
		else
		$this -> layout -> content = View::make('user/profilePage',array('user' => Auth::user()));
	}

	/*
     * Process the change of password
    */
	public function changePassword()
	{
		$id = Input::get('id');
		$user = User::find($id);
		$old_password = Input::get('old_pass');
		$messages = array();
		if (!Hash::check($old_password, $user->password)) {
			$message = 'la password attuale non è corretta';
			$errors = array('old_pass' => $message);
			Input::merge(array('old_pass' => $message));
			echo Input::get('old_pass');
			return Redirect::to('profile')->withErrors(array('test' => 'prova'));
//			$this -> layout -> content = View::make('user/profilePage',array('user' => Auth::user(),'errors' => $errors));
		}
		$rules = array('pass' => 'required|min:8|confirmed');
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			$messages = $validator->messages();
			echo $messages;
//			return Redirect::to('newShipment')->withErrors($validator);
		}
		$pass = Input::get('pass');
		$new_hash = Hash::make($pass);
		$user->password = $new_hash;
//		$user -> update();
//		return Redirect::to('profile');
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