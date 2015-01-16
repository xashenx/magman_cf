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
Route::get('/', function () {
    // TODO change to home
//    return "mettere la home!";
    return Redirect::to('home');
});


/* LOGIN */
Route::get('login', function () {
    if (!Auth::check()) {
        return View::make('loginForm');
    } else {
        return Redirect::to('home');
    }
});


Route::post('login', function () {
    /* Get the login form data using the 'Input' class */
    $userdata = array('username' => Input::get('username'), 'password' => Input::get('password'), 'active' => 1);

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
Route::get('logout', function () {
    Auth::logout();
    return Redirect::to('login');
});

/* Internal Page */
Route::post('shipment', 'ComicsController@showShipmentLoader');
Route::group(array('before' => 'auth'), function () {
    if (Auth::check()) {
        $privilege = Auth::user()->level_id;
        if ($privilege == 1) {
            Route::get('home', 'HomePageController@adminHome');
            Route::get('newShipment', 'ComicsController@showShipmentLoader');
            Route::get('addSeries', 'AdminController@addSeries');
            Route::get('addComic', 'AdminController@addComic');
            Route::get('addBox', 'AdminController@addBox');
            Route::post('saveBox', 'AdminController@saveBox');
            // routes for the Boxes pages
            Route::get('boxes', 'AdminController@manageBoxes');
            Route::get('boxes/{box_id}', 'AdminController@manageBox')->where('box_id', '[0-9]+');
            Route::get('boxes/{box_id}/comic/{comic_user_id}', 'AdminController@manageComicUser')->where('box_id', '[0-9]+')->where('comic_user_id', '[0-9]+');
            // routes for the Series pages
            Route::get('series', 'AdminController@manageSeries');
            Route::get('series/{series_id}', 'AdminController@manageSerie')->where('series_id', '[0-9]+');
            Route::get('series/{series_id}/{comic_id}', 'AdminController@manageComic')->where('series_id', '[0-9]+')->where('comic_id', '[0-9]+');
            // route for the Comics page
            Route::get('comics', 'ComicsController@listAllComics');
            Route::get('comics/{comic_id}', 'ComicsController@manageComic')->where('comic_id', '[0-9]+');
            // route to handle User model changes
            Route::post('createUser', 'UsersController@create');
            Route::post('updateUser', 'UsersController@update');
            Route::post('deleteUser', 'UsersController@delete');
            Route::post('restoreUser', 'UsersController@restore');
            // route to handle Series model changes
            Route::post('createSeries', 'SeriesController@create');
            Route::post('updateSeries', 'SeriesController@update');
            Route::post('deleteSeries', 'SeriesController@delete');
            Route::post('restoreSeries', 'SeriesController@restore');
            // route to handle SeriesUser model changes
            Route::post('createSeriesUser', 'SeriesUserController@create');
            Route::post('updateSeriesUser', 'SeriesUserController@update');
            Route::post('restoreSeriesUser', 'SeriesUserController@restore');
            Route::post('deleteSeriesUser', 'SeriesUserController@delete');
            // route to handle Comic model changes
            Route::post('createComic', 'ComicsController@create');
            Route::post('updateComic', 'ComicsController@update');
            Route::post('deleteComic', 'ComicsController@delete');
            Route::post('restoreComic', 'ComicsController@restore');
            // route to handle ComicUser model changes
            Route::post('createComicUser', 'ComicUserController@create');
            Route::post('boxes/createComicUser', 'ComicUserController@create');
            Route::post('updateComicUser', 'ComicUserController@update');
            Route::post('deleteComicUser', 'ComicUserController@delete');
            Route::post('restoreComicUser', 'ComicUserController@restore');
            // special events routes
            Route::post('buyComic', 'ComicUserController@buy');
            Route::post('loadShipment', 'ComicsController@loadShipment');
            Route::post('getNumberFromSeries', 'ComicsController@getNumberFromSeries');
        } else {
            Route::get('home', 'UserController@userHome');
            Route::get('box', 'UserController@box');
            Route::get('mail', 'MailController@mailToShop');
//            Route::get('series', 'UserController@listSeries');
//            Route::get('series/{series_id}', 'UserController@viewSeries')->where('id', '[0-9]+');
        }
        Route::get('profile', 'UserController@userProfile');
        Route::post('changePassword', 'UsersController@changePassword');
    } else {
        Route::get('home', function () {
            return View::make('homePage');
        });
    }

    //return URL::action('HomePageController@index');
    // Route::get('home', 'HomePageController@index');
    //return View::make('homePage');
    //return Comic::where('name', 'LIKE', '%città%')
    //  ->get();
});

// App::abort(404);
