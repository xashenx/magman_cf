<?php
class HomePageController extends BaseController {

    /**
     * Show the profile for the given user.
     */
    public function index()
    {
      $comic = ComicUser::find(1)->comic->series;
      //$comic = Comic::where('name', 'LIKE', '%città%')
       // ->get();
        return View::make('homePage', array('comic' => $comic));
    }

}
?>