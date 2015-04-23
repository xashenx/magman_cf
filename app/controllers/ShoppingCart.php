<?php

class ShoppingCart extends BaseController
{
  public function show($box_id)
  {
    $user = User::find($box_id);
    if(Cart::instance($box_id)->count()>0)
      $this->layout->content = View::make('admin/viewCart', array('user' => $user));
    else
      return Redirect::to('boxes/' . $box_id);
  }

  public function addToCart()
  {
    $comic_user = ComicUser::find(Input::get('id'));
    $user_id = Input::get('user_id');
    if ($comic_user) {
      if ($comic_user->user_id == $user_id && $comic_user->active && $comic_user->state_id < 3) {
        //Cart::add('product_id', 'product_name', quantity, price, array('size' => 'large'));
        // the last is optional, to define properties of the product
        $price = $comic_user->price - ($comic_user->price * $comic_user->discount / 100);
        number_format($price, 2, '.', '.');
        Cart::instance($user_id)->add($comic_user->id, $comic_user->comic->series->name . ' #' . $comic_user->comic->number, 1, $price, array());
//        Cart::instance($user_id)->add($comic_user->id,$comic_user->comic->series->name . ' #' . $comic_user->comic->number, 1,$price, array());
//        Cart::add('293ad','bizzz', 1, 19.95, array('size' => 'medium'));
      }
    }
    return Redirect::to('boxes/' . $user_id);
  }

  public function removeFromCart()
  {
    $comic_user = ComicUser::find(Input::get('id'));
    $user_id = Input::get('user_id');
    $path = Input::get('path');
    $cart = Cart::instance($user_id)->content();
    foreach ($cart as $row) {
      if ($row->id == $comic_user->id)
        Cart::instance($user_id)->remove($row->rowid);
    }
    if(Cart::instance($user_id)->count()>0)
      return Redirect::to($path . '/' . $user_id);
    else
      return Redirect::to('boxes/' . $user_id);
  }

  public function confirmCart()
  {
    $user_id = Input::get('user_id');
    $cart = Cart::instance($user_id)->content();
    foreach ($cart as $row) {
      $comicUser = ComicUser::find($row->id);
      $timestamp = date("Y-m-d H:i:s", time());
      $comicUser->buy_time = $timestamp;
      $comicUser->state_id = 3;
      $comicUser->update();
    }
    Cart::instance($user_id)->destroy();
    return Redirect::to('boxes/' . $user_id);
  }
}

?>
