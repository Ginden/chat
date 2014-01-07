<?php

class LoginController extends BaseController {

	/*
Route::post('/channel/{number}/moderation/ban-user/', 'ChatModController@banUser');
Route::post('/channel/{number}/moderation/show-bans/', 'ChatModController@showBans');
Route::post('/channel/{number}/moderation/show-users/', 'ChatModController@showUsers');
Route::post('/channel/{number}/moderation/give-access/', 'ChatModController@giveAccess');
Route::post('/channel/{number}/moderation/last-seen/', 'ChatModController@lastSeen');

	*/
	public function start() {
		if (ChatAuth::check()) {
			return View::make('home')->with(array(
				'title' => 'strona startowa'
				));
		}
		return View::make('nl_home')->with(array(
				'title' => 'strona startowa'
				));
	}
        public function loginForm(){
                return View::make('login')->with(array(
				'title' => 'zaloguj się'
			));
        }
        public function loginHandle(){
		if (Input::get('login_type') === 'key' && strlen(Input::get('unique_key')) > 5) {
			return Redirect::to('migrate')->with('unique_key', Input::get('unique_key'));
		}
                if (ChatAuth::loginBy(
			'password',
			Input::only('nick', 'password')
			)
		)
			return View::make('login_success')->with(array(
				'title' => 'zalogowano',
				'channels' => Chat::getChannels()
				));
		else {
			//var_dump(DB::getQueryLog());
			
			return Redirect::to('login')->with(array('error' => 'Nieprawidłowe dane logowania.'));
		}
        }
	public function logOut($token) {
		if (Session::token() === $token) {
			ChatAuth::logout();
			return Redirect::to('login')->with(array('message' => 'Nieprawidłowy token'));
		}
		App::abort(401);
	}
	public function getRegister() {
		return View::make('register');
	}
	public function postRegister() {
		$name = Wykop::getNameFromAccountKey(Input::get('wykop_key'));
		if ($name) {
			$user 			= new User;
			$user->name 		= $name;
			$user->identifier 	= $name;
			$user->password 	= Hash::make(Input::get('password'));
			$user->email 		= Input::get('email');
			$user->login_type	= 1;
			$user->save();
			return Redirect::to('login')->with(array('message' =>'Możesz się zalogować.'));
			
		}
		return Redirect::to('register')->with(array('message' =>'Błędna odpowiedź z WykopAPI'));
	}
}