<?php
class ComicsL2Controller extends BaseController {

	public function manageComic($comic_id) {
		$comic = Comic::find($comic_id);
		if ($comic != null)
			$this -> layout -> content = View::make('admin/editComic', array('comic' => $comic,'path' => '../'));
		else
			return Redirect::to('comics/' . $comic_id);
	}
}
?>