<?php
class HomePageController extends BaseController {

    /**
     * Show the profile for the given user.
     */
    protected $layout = 'layouts.master';
    public function index()
    {
      $comic = ComicUser::find(1)->comic->series;
      //$comic = Comic::where('name', 'LIKE', '%città%')
      // ->get();
      $this->layout->content = View::make('homePage', array('comic' => $comic));
    }

}
?>