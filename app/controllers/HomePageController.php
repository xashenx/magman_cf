<?php

class HomePageController extends BaseController
{

  /**
   * Show the profile for the given user.
   */

  public function index()
  {
    //$comic = Comic::where('name', 'LIKE', '%città%')
    // ->get();
    $this->layout->title = 'Tomu';
    $this->layout->content = View::make('homePage');
  }

  /*
   * Displays the home page for an administrator of the platform
   */
  public function adminHome()
  {
    /*
     * Insolvent and defaulting users:
     * - insolvent: due > 5
     * - defaulting: not buying for at least 3 months
     */
    $boxes = User::where('active', '=', '1')->get();
    $insolvency_threshold = ShopConf::find(1);
    $defaulting_threshold = ShopConf::find(2);
    $inv_status = $this->module_state('inventory');
    /* BEGIN SHOP CART MODULE */
    $carts = $this->checkForAbandonedCarts($boxes);
    /* END SHOP CART MODULE */
    if ($inv_status == 1)
      $toOrder = DB::select('SELECT s.id as sid,c.id as cid,s.name, s.version,c.number, c.available, c.image as image, cu.to_order, (cu.to_order-c.available) as need FROM ((SELECT count(*) as to_order, comic_id FROM bm_comic_user WHERE state_id = 1 and active = 1 GROUP BY comic_id) as cu LEFT JOIN bm_comics as c ON cu.comic_id = c.id) LEFT JOIN bm_series as s ON  s.id = series_id WHERE  (cu.to_order-c.available) > 0');
    else
      $toOrder = DB::select('SELECT s.id as sid,c.id as cid,s.name, s.version,c.number, c.available, c.image as image, cu.to_order, cu.to_order as need, pub.name as publisher FROM (((SELECT count(*) as to_order, comic_id FROM bm_comic_user WHERE state_id = 1 and active = 1 GROUP BY comic_id) as cu LEFT JOIN bm_comics as c ON cu.comic_id = c.id) LEFT JOIN bm_series as s ON  s.id = series_id) LEFT JOIN bm_publishers as pub ON s.publisher_id = pub.id');
    $insolvents = $this->buildInsolventArray($boxes, $insolvency_threshold);
    $insolvent_boxes = $this->buildInsolventBoxesArray($insolvents);
    $defaultings = $this->buildDefaultingArray($boxes, $defaulting_threshold);
    $defaulting_boxes = $this->buildDefaultingBoxesArray($defaultings);
    $this->layout->content = View::make('admin/homePage', array('insolvents' => $insolvents, 'defaultings' => $defaultings, 'to_order' => $toOrder, 'defaultingBoxes' => $defaulting_boxes, 'insolventBoxes' => $insolvent_boxes,'abb_carts' => $carts));
  }

  /*
   * Displays the home page for an user of the platform
   */
  public function userHome()
  {
    $this->layout->content = View::make('user/userHomePage');
  }

  public function buildInsolventArray($boxes, $insolvency_treshold)
  {
    $insolvent = array();
    foreach ($boxes as $box) {
      // check available comics and due
      $comics = $box->listComics()->whereRaw('state_id < 3 and active = 1')->get();
      $due_counter = 0;
      foreach ($comics as $comic) {
        if ($comic->comic->available > 0) {
          $due_counter += round($comic->price, 2);
        }
      }
      $due_counter = $due_counter - ($due_counter * $box->discount / 100);
      if ($due_counter > $insolvency_treshold->value) {
//				$insolvent = array_add($insolvent,'Insolvente (' . $due_counter . '€)',$box);
        $insolvent = array_add($insolvent, $box->id, 'Giacenza (' . $due_counter . ' €)');
        // echo $box->name . " insolvent: " . $due_counter . "<br>";
      }
    }
    return $insolvent;
  }

  public function buildInsolventBoxesArray($insolvents)
  {
    $boxes = array();
    foreach ($insolvents as $box_id => $value) {
      $boxes = array_add($boxes, $box_id, User::find($box_id));
    }
    return $boxes;
  }

  public function buildDefaultingArray($boxes, $defaulting_threshold)
  {
    $defaulting = array();
    foreach ($boxes as $box) {
      $last_buy = $box->lastBuy->max('buy_time');
      if (strtotime("-" . $defaulting_threshold->value
          . " days") > strtotime($last_buy) && $last_buy != null
      ) {
        $defaulting = array_add($defaulting, $box->id, 'Disperso (' . date('d/m/Y', strtotime($last_buy)) . ')');
      }
    }
    return $defaulting;
  }

  public function buildDefaultingBoxesArray($defaultings)
  {
    $boxes = array();
    foreach ($defaultings as $box_id => $value) {
      $boxes = array_add($boxes, $box_id, User::find($box_id));
    }
    return $boxes;
  }

  public function module_state($module_description)
  {
    $modules = Modules::where('description', '=', $module_description)->get();
    $state = 0;
    if (count($modules) == 1) {
      foreach ($modules as $module) {
        $state = $module->active;
      }
    }
    return $state;
  }

  /* BEGIN SHOP CART MODULE */
  public function checkForAbandonedCarts($boxes){
    $abandoned_carts = array();
    foreach($boxes as $box){
      if(Cart::instance($box->id)->count()>0)
        $abandoned_carts = array_add($abandoned_carts,$box->id,Cart::instance($box->id)->count());
    }
    return $abandoned_carts;
  }
  /* END SHOP CART MODULE */

}

?>
