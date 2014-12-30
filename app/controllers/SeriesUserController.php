<?php
class SeriesUserController extends BaseController {
	protected $layout = 'layouts.master';

	public function create() {
		$user_id = Input::get('user_id');
		$series_id = Input::get('series_id');
		$series = Series::find($series_id);
		// check that the series exists and is active!
		if ($series != null && $series -> active) {
			// check that the user is not already following that series!
			$series_user_collection = SeriesUser::whereRaw('user_id = ' . $user_id .
			 ' and series_id = ' . $series_id)->get();
			if (count($series_user_collection) == 0) {
				echo "sono qui2";
				$series_user = new SeriesUser;
				$series_user -> series_id = $series_id;
				$series_user -> user_id = $user_id;
				$series_user -> save();
			}
		}
		// TODO warnings!
		return Redirect::to('boxes/' . $user_id);
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
	
	public function delete(){
		$su_id = Input::get('id');
		$user_id = Input::get('user_id');
		$seriesUser = SeriesUser::find($su_id);
		$seriesUser -> active = 0;
		$comics = $seriesUser -> series -> listActive;
		foreach ($comics as $comic) {
			DB::update('update comic_user set active = 0 where comic_id = ' . $comic -> id);
		}
		$seriesUser -> update();
		return Redirect::to('boxes/' . $user_id);
	}
	
	public function restore(){
		$su_id = Input::get('id');
		$user_id = Input::get('user_id');
		$seriesUser = SeriesUser::find($su_id);
		$seriesUser -> active = 1;
		$seriesUser -> update();
		return Redirect::to('boxes/' . $user_id);
	}
}
?>