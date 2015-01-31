<?php
class SeriesController extends BaseController {

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
//		if (Input::get('active'))
//			$series -> active = 1;
//		else
//			$series -> active = 0;
		$series -> save();
		return Redirect::to('series/' . $id);
	}

	public function delete() {
		$series_id = Input::get('id');
		$path = Input::get('return');
		$rules = array('id' => 'required|numeric|exists:bm_series,id,active,1');
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to($path)->withErrors($validator);
		} else{
			$series = Series::find($series_id);
			$series -> active = 0;
			$series -> update();
			$comics = $series -> listComics;
			$this -> deleteComics($comics);
			$this -> deleteSeriesUser($series_id);
			return Redirect::to($path);
		}
	}

	public function restore() {
		$series_id = Input::get('id');
		$path = Input::get('return');
		$rules = array('id' => 'required|numeric|exists:bm_series,id,active,0');
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to($path)->withErrors($validator);
		} else {
			$series = Series::find($series_id);
			$series->active = 1;
			$series->update();
			if (Input::get('comics') == 1) {
				DB::table('bm_comics')->where('series_id', $series_id)->update(array('active' => 1));
			}
			return Redirect::to($path);
		}
	}

	public function deleteComics($comics) {
		foreach ($comics as $comic) {
			DB::table('bm_comic_user') -> where('comic_id', $comic->id) -> update(array('active' => 0));
			$comic -> active = 0;
			$comic -> update();
		}
	}

	public function deleteSeriesUser($series_id) {
		DB::table('bm_series_user') -> where('series_id', $series_id) -> update(array('active' => 0));
		// $seriesUser = SeriesUser::where('series_id',$series_id)->get();
		// foreach ($seriesUser as $box) {
			// $box -> active = 0;
			// $box -> update();
		// }
	}

	// public function deleteComicUser($comics) {
		// foreach ($comics as $comic) {
			// DB::table('comic_user') -> where('comic_id', $comic->id) -> update(array('active' => 0));
		// }
	// }

	// public function restoreComics($comics) {
		// foreach ($comics as $comic) {
			// $comic -> active = 1;
			// $comic -> update();
		// }
	// }

}
?>