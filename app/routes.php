<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

/* LOGIN */
Route::get('login', function()
{
  return View::make('loginForm');
});

Route::post('login', function()
{
  /* Get the login form data using the 'Input' class */
  $userdata = array(
      'username' => Input::get('username'),
      'password' => Input::get('password')
  );

  if(Input::get('persist') == 'on')
    $isAuth = Auth::attempt($userdata, true);
  else
     $isAuth = Auth::attempt($userdata);


  if($isAuth) {
    // we are now logged in, go to home
    return Redirect::to('home');
  } else {
    return Redirect::to('login');
  }
});

/* LOGOUT */
Route::get('logout', function()
{
  Auth::logout();
  return Redirect::to('login');
});

/* Internal Page */

Route::get('home', array('before' => 'auth', function()
{
    return View::make('homePage');
}));
