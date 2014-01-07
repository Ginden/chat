<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
	
	
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (ChatAuth::guest()) return App::abort(403);
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (ChatAuth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});




Route::filter('auth.chat.basic', function($route, $request) {
	$channel = Route::input('channel');
	if (!(Chat::getPermissionsLevel($channel, CurrentUser::get()->id) > 0)) {
		return App::abort(403);
	}
});

Route::filter('auth.chat.mod', function($route, $request) {
	$channel = Route::input('channel');
	if (!(Chat::getPermissionsLevel($channel, CurrentUser::get()->id) > 1)) {
		return App::abort(403);
	}
});

Route::filter('auth.chat.admin', function($route, $request) {
	$channel = Route::input('channel');
	if (!(CurrentUser::get()->id === 1)) {
		return App::abort(403);
	}
});

App::error(function(Exception $exception, $code){

    // Careful here, any codes which are not specified
    // will be treated as 500

    if ( ! in_array($code,array(401,403,404/*,500*/))){
       return;
    }

    // assumes you have app/views/errors/401.blade.php, etc
    $view = "errors/$code";

    // add data that you want to pass to the view
    $data = array('code'=>$code);

    // switch statements provided in case you need to add
    // additional logic for specific error code.

    switch ($code) {
       case 401:
       return Response::view($view, $data, $code);

       case 403:
       return Response::view($view, $data, $code);

       case 404:
       return Response::view($view, $data, $code);

       case 500:
       return Response::view($view, $data, $code);

   }

});


