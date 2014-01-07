<?php


class User extends Eloquent implements \Illuminate\Auth\UserInterface {
	protected $table = 'chat_accounts';
        protected $hidden = array('password', 'unikalny_klucz', 'accountkey', 'login_type', 'identifier');
	protected $timetamps = false;
        protected $primaryKey = "id";
        public function getAuthPassword() { return $this->password; }
        public function getAuthIdentifier() { return $this->getKey(); }

}