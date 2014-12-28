<?php
class AdminL3Controller extends BaseController {
	protected $layout = 'layouts.master_level3';

	public function manageComic($series_id, $comic_id) {
		$comic = Comic::find($comic_id);
		if ($comic != null && $comic->series->id == $series_id)
			$this -> layout -> content = View::make('admin/editComic', array('comic' => $comic, 'path' => '../../'));
		else
			return Redirect::to('series/' . $series_id);
	}

	public function buildAvailableArray($boxes) {
		$available = null;
		foreach ($boxes as $box) {
			// check available comics and due
			$comics = $box -> listComics() -> whereRaw('state_id < 3') -> get();
			$available_counter = 0;
			foreach ($comics as $comic) {
				if ($comic -> comic -> available > 1) {
					$available_counter++;
				}
			}
			$available = array_add($available, $box -> id, $available_counter);
		}
		return $available;
	}

	public function buildDueArray($boxes) {
		$due = null;
		foreach ($boxes as $box) {
			// check available comics and due
			$comics = $box -> listComics() -> whereRaw('state_id < 3') -> get();
			$due_counter = 0;
			foreach ($comics as $comic) {
				if ($comic -> comic -> available > 1) {
					$due_counter += round($comic -> price, 2);
				}
			}
			$due_counter = $due_counter - ($due_counter * $box -> discount / 100);
			$due = array_add($due, $box -> id, $due_counter);
		}
		return $due;
	}

}
?>