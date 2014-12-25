<?php
class SeriesController extends BaseController {
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
		return Redirect::to('series/' . $series->id);
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

}
?>