<?php
class ComicsController extends BaseController {
	protected $layout = 'layouts.master';
	protected $layou = 'layouts.master_level2';

	public function create() {
		$series_id = Input::get('series_id');
		$comic = new Comic;
		$comic -> name = Input::get('name');
		$comic -> number = Input::get('number');
		$comic -> price = Input::get('price');
		$comic -> series_id = $series_id;
		$comic -> available = Input::get('available');
		$comic -> save();
		$this->updateComicUser($series_id,$comic);
		return Redirect::to('series/' . $series_id);
	}

	public function update() {
		$id = Input::get('id');
		$comic = Comic::find($id);
		$comic -> name = Input::get('name');
		$comic -> number = Input::get('number');
		$comic -> available = Input::get('available');
		if (Input::get('active'))
			$comic -> active = 1;
		else
			$comic -> active = 0;
		$comic -> save();
		return Redirect::to('series/' . $comic->series_id . '/' . $id);
	}
	
	public function updateComicUser($series_id,$comic){
		$series_user = SeriesUser::whereRaw('series_id = ' . $series_id . ' and active = 1')->get();
		foreach ($series_user as $user) {
			$comicUser = new ComicUser;
			$comicUser -> comic_id = $comic -> id;
			$comicUser -> user_id = $user -> user_id;
			$comicUser -> price = $comic -> price;
			$comicUser->save();
		}
	}
	
	public function listAllComics(){
		$comics = Comic::all();
		$this -> layout -> content = View::make('admin/manageComics', array('comics' => $comics));
	}
}
?>