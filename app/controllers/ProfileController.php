<?php
class ProfileController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showProfile($profile) {
		return View::make('profile')->with(array(
						'user' => User::find($profile)
						));
	}
	public function showMyProfile($profile) {
		return $this->showProfile(Auth::user()->id);
	}
        public function getEditProfile() {
                return View::make('edit_profile');
        }
        public function postEditProfile() {
            
        }
        public function getMigrateLoginType() {
		Session::reflash();
                return View::make('migrate')->with(array('title' => 'zmiana metody logowania'));
        }
        public function postMigrateLoginType() {
		Session::reflash();
		$user = User::where(
				'unikalny_klucz', '=', substr(Input::get('unique_key'), 0, 50))->first();
		$pass_len = strlen(Input::get('password')) > 4;
		$pass_both = Input::get('password') === Input::get('password_repeat');
		if ($user && $pass_len  && $pass_both) {
			$user->email = Input::get('email');
			$user->password = hash('sha512', Input::get('password'));
			$user->login_type = 1;
			$user->unikalny_klucz = '';
			$user->save();
			Chat::createChannel('kanał prywatny '.$user->name,
					    $user->id+1000,
					    'priv.png',
					    'kanał prywatny',
					    'kanał prywatny');
			Chat::changePrivilages($user->id+1000, $user->id, 2);
			return Redirect::to('login')->with('message', 'Udana zmiana typu logowania.');
		}
		else {
			$msg = $pass_both ? 'Niezgodne hasła.' : false;
			$msg = $msg ? $msg : 'Za krótkie hasło.';
			return Redirect::to('login')->with(array('message' => $msg));
		}
        }
}