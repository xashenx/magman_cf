<?php
class ComicsController extends BaseController {
	protected $layout = 'layouts.master';

	public function create() {
		$series_id = Input::get('series_id');
		$comic = new Comic;
		$comic -> name = Input::get('name');
		$comic -> number = Input::get('number');
		$comic -> price = Input::get('price');
		$comic -> series_id = $series_id;
		$comic -> available = Input::get('available');
		$comic -> save();
		$this -> updateComicUser($series_id, $comic);
		return Redirect::to('series/' . $series_id);
	}

	public function update() {
		$id = Input::get('id');
		$comic = Comic::find($id);
		$comic -> name = Input::get('name');
		$comic -> number = Input::get('number');
		$comic -> available = Input::get('available');
		$new_price = Input::get('price');
		if ($new_price != $comic -> price) {
			$comic -> price = $new_price;
			DB::update('update comic_user set price = ' . $new_price . ' where comic_id = ' . $id . ' and state_id < 3');
		}
		if (Input::get('active'))
			$comic -> active = 1;
		else {
			$comic -> active = 0;
			DB::update('update comic_user set active = 0 where comic_id = ' . $id);
		}
		$comic -> save();
		$return = Input::get('return');

		if ($return == 'comics')
			return Redirect::to('comics/' . $id);
		elseif ($return == 'series')
			return Redirect::to('series/' . $comic -> series_id . '/' . $id);
		else
			return "error";
	}

	public function remove() {
		$id = Input::get('id');
		$comic = ComicUser::where('comic_id', '=', $id);
		$comic -> active = 0;
		$comic -> update();
		return Redirect::to('boxes/' . $comic -> series_id . '/' . $id);
	}

	public function updateComicUser($series_id, $comic) {
		$series_user = SeriesUser::whereRaw('series_id = ' . $series_id . ' and active = 1') -> get();
		foreach ($series_user as $user) {
			$comicUser = new ComicUser;
			$comicUser -> comic_id = $comic -> id;
			$comicUser -> user_id = $user -> user_id;
			$comicUser -> price = $comic -> price;
			$comicUser -> save();
		}
	}

	public function listAllComics() {
		$comics = Comic::all();
		$this -> layout -> content = View::make('admin/manageComics', array('comics' => $comics));
	}

	public function showShipmentLoader() {
		$comics = Comic::where('active', '=', '1');
		$this -> layout -> content = View::make('admin/shipmentLoader', array('comics' => $comics));
	}

	public function loadShipment() {
		$rules = array('comic_id' => 'required|min:1|integer|exists:comics,id,active,1','amount' => 'required|min:1|integer');
		$validator = Validator::make(Input::all(), $rules);
		if ($validator -> fails()) {
			$messages = $validator -> messages();
			return Redirect::to('newShipment')->withErrors($validator);
		} else {
			$comic_id = Input::get('comic_id');
			$amount = Input::get('amount');
			$comic = Comic::find($comic_id);
			$comic -> available += $amount;
			$comic -> update();
			return Redirect::to('newShipment');
		}
	}

	public function getNumberFromSeries(){
		$this -> layout = null;
		$series_id = Input::get('series_id');
		$comics = Comic::where('series_id','=',$series_id)->get();
		echo $comics;
	}
}
?>