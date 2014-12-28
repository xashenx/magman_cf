<?php
class ComicUserController extends BaseController {
	protected $layout = 'layouts.master';
	protected $layout2 = 'layouts.master_level2';

	public function create() {
		$series = new Series;
		$series -> name = Input::get('name');
		$series -> version = Input::get('version');
		$series -> author = Input::get('author');
		if (Input::get('type_id') != null)
			$series -> type_id = Input::get('type_id');
		if (Input::get('subtype_id') != null)
			$series -> subtype_id = Input::get('subtype_id');
		$series -> save();
		return Redirect::to('series/' . $series -> id);
	}

	public function update() {
		$id = Input::get('id');
		$series = Series::find($id);
		$series -> name = Input::get('name');
		$series -> version = Input::get('version');
		$series -> author = Input::get('author');
		if (Input::get('type_id') != null)
			$series -> type_id = Input::get('type_id');
		if (Input::get('subtype_id') != null)
			$series -> subtype_id = Input::get('subtype_id');
		if (Input::get('active'))
			$series -> active = 1;
		else
			$series -> active = 0;
		$series -> save();
		return Redirect::to('series/' . $id);
	}

	public function delete() {
		$id = Input::get('id');
		$user_id = Input::get('user_id');
		$comics = ComicUser::whereRaw('comic_id = ' . $id . ' and user_id = ' . $user_id) -> get();
		foreach ($comics as $comic) {
			$comic -> active = '0';
			$comic -> update();
		}
		return Redirect::to('boxes/' . $user_id);
	}

	public function buy() {
		$id = Input::get('id');
		$user_id = Input::get('user_id');
		$comics = ComicUser::whereRaw('comic_id = ' . $id . ' and user_id = ' . $user_id) -> get();
		foreach ($comics as $comic) {
			$timestamp = date("Y-m-d H:i:s", time());
			$comic -> buy_time = $timestamp;
			$comic -> state_id = 3;
			$comic -> update();
		}
		return Redirect::to('boxes/' . $user_id);
	}

}
?>