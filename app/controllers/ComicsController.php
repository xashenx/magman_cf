<?php
class ComicsController extends BaseController {
	protected $layout = 'layouts.master';
	protected $layout2 = 'layouts.master_level2';

	public function create() {
		$series_id = Input::get('series_id');
		$comic = new Comic;
		$comic -> name = Input::get('name');
		$comic -> number = Input::get('number');
		$comic -> price = Input::get('price');
		$comic -> series_id = $series_id;
		$comic -> available = Input::get('available');
		$comic -> save();
		return Redirect::to('series/' . $series_id);
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