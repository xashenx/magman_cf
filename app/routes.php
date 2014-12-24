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

			Route::resource('series.update','SeriesController');
Route::get('example', function(){
  return View::make('example');
});

Route::get('/', function() {
	return View::make('hello');
});

/* LOGIN */
Route::get('login', function() {
	return View::make('loginForm');
});

Route::post('login', function() {
	/* Get the login form data using the 'Input' class */
	$userdata = array('username' => Input::get('username'), 'password' => Input::get('password'));

	if (Input::get('persist') == 'on')
		$isAuth = Auth::attempt($userdata, true);
	else
		$isAuth = Auth::attempt($userdata);

	if ($isAuth) {
		// we are now logged in, go to home
		return Redirect::to('home');
	} else {
		return Redirect::to('login');
	}
});

/* LOGOUT */
Route::get('logout', function() {
	Auth::logout();
	return Redirect::to('login');
});

/* Internal Page */

Route::group(array('before' => 'auth'), function() {
	if (Auth::check()) {
		$privilege = Auth::user() -> level_id;
		if ($privilege == 1) {
			Route::get('home', 'HomePageController@adminHome');
			Route::get('addSeries', 'AdminController@addSeries');
			Route::get('addComic', 'AdminController@addComic');
			Route::get('addBox', 'AdminController@addBox');
			Route::get('series', 'AdminController@manageSeries');
			Route::get('boxes', 'AdminController@manageBoxes');
			Route::get('boxes/{id}', 'AdminL2Controller@manageBox')->where('id', '[0-9]+');
			Route::get('series/{series_id}', 'AdminL2Controller@manageSerie')->where('id', '[0-9]+');
			Route::get('series/{series_id}/{comic_id}', 'AdminL3Controller@manageComic')
			->where('series_id', '[0-9]+')->where('comic_id','[0-9]+');
			Route::get('series.update','AdminController@updateSeries');
			Route::resource('series.update','SeriesController');
		} else {
			Route::get('home', 'UserController@userHome');
			Route::get('box', 'UserController@box');
		}
	}
	//return URL::action('HomePageController@index');
	// Route::get('home', 'HomePageController@index');
	//return View::make('homePage');
	//return Comic::where('name', 'LIKE', '%città%')
	//  ->get();
});

// App::abort(404);
