<?php
class UserL2Controller extends BaseController {
	protected $layout = 'layouts.master_level2';

	/**
	 * Displays the details of one series
	 */
	public function viewSeries($series_id) {
		$series = Series::find($series_id);
		$comics = Comic::whereRaw('active = 1 and series_id = ' . $series_id) -> get();
		if ($series != null && $series -> active)
			$this -> layout -> content = View::make('user/viewSeries',
			 array('series' => $series,'comics' => $comics));
		else
			return Redirect::to('series');
	}

}
?>