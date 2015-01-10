<?php
class ComicUserController extends BaseController {

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
		$cu_id = Input::get('cu_id');
		$u_id = Input::get('user_id');
		$comicUser = ComicUser::find($cu_id);
		$comicUser -> price = Input::get('price');
		if (Input::get('active'))
			$comicUser -> active = 1;
		else
			$comicUser -> active = 0;
		$comicUser -> update();
		return Redirect::to('boxes/' . $u_id);
	}

	public function delete() {
		$id = Input::get('id');
		$user_id = Input::get('user_id');
		$comics = ComicUser::whereRaw('id = ' . $id . ' and user_id = ' . $user_id) -> get();
		foreach ($comics as $comic) {
			$comic -> active = '0';
			$comic -> update();
		}
		return Redirect::to('boxes/' . $user_id);
	}

	public function buy() {
		$id = Input::get('id');
		$user_id = Input::get('user_id');
		$comics = ComicUser::whereRaw('id = ' . $id . ' and user_id = ' . $user_id) -> get();
		foreach ($comics as $comicUser) {
			$timestamp = date("Y-m-d H:i:s", time());
			$comicUser -> buy_time = $timestamp;
			$comicUser -> state_id = 3;
			$comic = $comicUser -> comic;
			$comic -> available -= 1;
			$comicUser -> update();
			$comic -> update();
		}
		 return Redirect::to('boxes/' . $user_id);
	}

}
?>