<?php

class ChatController extends BaseController {
        public function channel($channel = 0){
                return View::make('channel')->with(array(
			'accessLevel' => Chat::getPermissionsLevel($channel, ChatAuth::user()->id),
			'channel' => Chat::getChannelInfo($channel)
		));
        }
        public function addMessage($channel = 0){
		$message 	 = Input::get('message');
		$currentUser 	 = CurrentUser::get();
                return Response::json(Chat::addMessage($channel, $currentUser->id, $message));
        }
        public function messages($channel = 0){
		
		$last 	 	 = Input::get('last');
		$currentUser 	 = CurrentUser::get();
		$messages = Chat::getMessages($channel, $currentUser, $last);
		if (count($messages) === 0){
			/*$query = "SELECT 
			FROM `chat_messages`
			WHERE `chat_messages`.`channel` = ?
			AND
				`chat_messages`.`user` = ''
			AND
				`chat_messages`.`timestamp` < (UNIX_TIMESTAMP()-58*59)
			ORDER BY `chat_messages`.`id` DESC LIMIT 1";
			$newMessages = DB::select($query, array($channel));
			if (count($newMessages) == 0) {
				Chat::addMessage($channel, Chat::BOT_USER, ' ');
			}*/
		}
                return Response::json($messages);
        }
	public function listChannels() {
		return View::make('channels')->with(
			array(
			      'title'=>'lista kanałów',
			      'channels' => Chat::getChannels()
			      )
			);
	}
        public function showMembers($channel = 0){
		$users = Chat::getUsersOnline($channel);
		Chat::updateOnline($channel, ChatAuth::user()->id);
                return Response::json($users);
        }
}