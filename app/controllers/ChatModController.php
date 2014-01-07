<?php

class ChatModController extends BaseController {

	/*
Route::post('/channel/{number}/moderation/ban-user/', 'ChatModController@banUser');
Route::post('/channel/{number}/moderation/show-bans/', 'ChatModController@showBans');
Route::post('/channel/{number}/moderation/show-users/', 'ChatModController@showUsers');
Route::post('/channel/{number}/moderation/give-access/', 'ChatModController@giveAccess');
Route::post('/channel/{number}/moderation/last-seen/', 'ChatModController@lastSeen');

	*/


        public function banUser($number = 0){
                return View::make('channel');
        }
        public function showBans($number = 0){
                return View::make('messages');
        }
        public function showUsers($number = 0){
                return View::make('add-message');
        }
        public function giveAccess($number = 0){
                return View::make('online-users');
        }
        public function lastSeen($number = 0){
                return View::make('online-users');
        }
}