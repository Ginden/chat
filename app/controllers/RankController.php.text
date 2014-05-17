<?php
class RankController extends BaseController {
        public function base(){
            $result = DB::select('SELECT
                                 `chat_accounts`.`name` ,
                                 COUNT(*) as `messages`
                                 FROM (`chat_messages` CROSS JOIN `chat_accounts`)
                                 WHERE (
                                    `chat_accounts`.`id` = `chat_messages`.`user`
                                    AND
                                    `chat_messages`.`timestamp` > (UNIX_TIMESTAMP()-60*60*24*7)
                                    AND
                                    `chat_messages`.`to` = \'\')
                                GROUP BY `chat_messages`.`user`
                                ORDER BY COUNT(*)  DESC LIMIT 0, 10');
            return View::make('rank')->with(array('rank'=>$result, 'title'=>'ranking'));
        }
}
