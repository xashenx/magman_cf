<?php
class HomePageController extends BaseController {

    /**
     * Show the profile for the given user.
     */
    public function index()
    {
      $comic = Comic::where('name', 'LIKE', '%città%')
        ->get();
        return View::make('homePage', array('comic' => $comic));
    }

}
?>