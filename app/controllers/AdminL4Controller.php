<?php
class AdminL4Controller extends BaseController {
	protected $layout = 'layouts.master_level4';

	public function manageComicUser($box_id, $comic_user_id) {
		$comicUser = ComicUser::find($comic_user_id);
		// conditions of redirect: no comicUser,
		if ($comicUser == null || $comicUser -> active == 0 || $comicUser -> state_id == 3 || $comicUser -> user_id != $box_id)
			return Redirect::to('boxes/' . $box_id);
		else
			$this -> layout -> content = View::make('admin/editComicUser', array('comic' => $comicUser));
	}

}
?>