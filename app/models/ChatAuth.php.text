<?php
class ChatAuth {
    public static function check() {
        return Session::has('logged.user');
    }
    public static function guest() {
        return !Session::has('logged.user');
    }
    public static function login($user) {
        if ($user instanceof User) {
            Session::put('logged.user', $user);
            return true;
        }
        return false;
    }
    public static function logout() {
        Session::forget('logged.user');
    }
    public static function user() {
        return Session::get('logged.user', function(){
            return null;
            });
    }
    public static function loginBy($loginType, $authData){
        
        if ($loginType === 'user_key' || $loginType === 'key') {
            $who = User::where(
                    'unikalny_klucz', '=', substr($authData['unique_key'], 0, 50)
                )->where('login_type', '=', 0)->first();
            ChatAuth::login(
                $who, true);
            return ChatAuth::user();
        }
        else if ($loginType === 'password') {
            $who = User::where(
                    'identifier', '=', $authData['nick']
                    )
                    ->where(
                        'login_type', '=', '1'
                    )
                    ->where(
                         'password' , '=', hash('sha512', $authData['password'])
                    )->first();
            $result = ChatAuth::login(
                $who, true);
            return ChatAuth::user();
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    public static function createUser($name, $password, $email) {
        
    }
}
    


?>