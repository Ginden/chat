<?php
class Chat {
    const BOT_USER 	 	= 94;
    const ROLL_MAX_DICES 	= 10;
    const CURRENT_PERIOD 	= 0;
    const USER_LEVEL_BANNED 	= -1;
    const USER_LEVEL_NO_ACCESS  = 0;
    const USER_LEVEL_NORMAL 	= 1;
    const USER_LEVEL_MODERATOR 	= 2;
    const USER_LEVEL_ADMIN 	= 3;
    // converts time (in seconds) to natural language, rounded (eg. 65 seconds to "1 minut" (1 minute))
    static function secondsToNatural($time) {
	$naturalTime = '';
	if ($time < 60) {
            $naturalTime = $time." sekund";
        }
        elseif ($time >= 60 && $time < 60*60) {
            $naturalTime = round($time/60, 1)." minut";
        }
        elseif ($time >= 60*60 && $time < 24*3600) {
            $naturalTime = round($time/3600, 2)." godzin";
        }
        elseif ($time >= 24*60*60 && $time < 7*24*60*60) {
            $naturalTime = round($time/(24*3600), 2)." dni";
        }
        elseif ($time >= 7*24*60*60) {
            $naturalTime = round($time/(7*24*3600), 2)." tygodni";
        }
	return $naturalTime;
    }
    // retrieves random "funny" text from database
    static function getRandomText() {
	$randomMessage = head(DB::select('SELECT * FROM `chat_random_texts` where `when` = ? ORDER BY RAND() LIMIT 1', array(Chat::CURRENT_PERIOD)));
	return '/me '.$randomMessage->text.'...';
    }
    // 
    static function roll($message){
        $components     = explode(' ', $message);
        $allowedDices = Array(2, 3, 4, 6, 8, 10, 12, 20, 100);
        $components[0] = '/roll';
                $diceSize   = intval($kostka[1]);
                $diceCount  = intval($kostka[2]);
                if ($diceCount === 0 || $diceCount === 1) {
                        $diceCount = 1;
                        $t = '';
                }
                else {
                    $t = $diceCount;
                }
                $subResults = array();
                if (!in_array($diceSize, $allowedDices))
                     $kostka_size = 6;
                if ($diceCount == 1) {
                    $wynik = rand(1, $diceSize);
                    $subresults = '';
                }
                else {
                    if ($liczba_kostek > Chat::ROLL_MAX_DICES) {
                        $liczba_kostek = Chat::ROLL_MAX_DICES;
                    }
                    for ($i = 1; $i <= $diceCount; $i++) {
                        $subresults[] = rand(1, $diceSize);
                    }
                    $wynik = array_sum($subresults);
                    $subresults = ' ('.implode(', ', $subresults).' )';
                }
                return '/me rzuca '.$t.'k'.$kostka_size.' i wyrzuca: '.$wynik.$subresults.'.';

    }
    
    static function addMessage($channel, $userId, $text) {
        $user = $userId;
        $msgType = null;
        $botThanks = false;
        if (ltrim($text, ' ') === '') {
                $text = Chat::getRandomText();
                if(strpos($text, 'GindenBot') > 0) {
                    $botThanks = true;
                }
        }
        if (strpos($text, '/roll') === 0) {
            $text = Chat::roll($message);
            $msgType = 'd';
        }
        if ($user === 94) {
            $ip = '127.0.0.1';
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $priv = '';
        if (substr($text, 0, 4) === '/msg') {
            $priv = substr($text, 5);
            $pozycja = strpos($priv, ' ');
            $priv = substr($priv, 0, $pozycja);
            $priv = str_replace('@', '', $priv);
            $text = substr($text, 6+strlen($priv));
        }
        
        $sql = 'INSERT INTO `chat_messages`
                (`id`, `user`, `message`, `timestamp`, `channel`, `to`, `special`, `ip`)
                VALUES (default,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
                )';
        $howMuch = DB::insert($sql, array(
                               $userId,
                               $text,
                               time(),
                               $channel,
                               $priv,
                               $msgType,
                               $ip
                               ));
        if ($botThanks === true) {
            Chat::addMessage($channel, Chat::BOT_USER, 'Dziękuję, miło mi.');
        }
        return ($howMuch === 1);
    }
    // retrieves array of messages for given channel, user and last seen message
    static function getMessages($channel, $currentUser, $last=0) {
        $query = "SELECT SQL_CACHE `chat_accounts`.`name` , `chat_messages` . *
                    FROM `chat_messages`
		    CROSS JOIN `chat_accounts`
		    WHERE (
                        (`chat_messages`.`id` > ? AND `chat_messages`.`channel` = ?)
                        AND
                        (
                            (`chat_messages`.`user` = ?)
                            OR
                            (`chat_messages`.`to` = ?)
                            OR
                            (`chat_messages`.`to` = '')
                        )
                        AND
                        (
                            `chat_accounts`.`id` = `chat_messages`.`user`
                        )
                    )
                    ORDER BY `chat_messages`.`id` DESC LIMIT 35";
	    $arr = array($last,
                        $channel,
                        $currentUser->id,
                        $currentUser->name);
            return DB::select($query, $arr);
    }
    // retrieves users online in last 45 seconds
    static function getUsersOnline($channel) {
        $sql =  "SELECT SQL_CACHE `chat_accounts`.`name` as `user`
            FROM `chat_users_online`
            CROSS JOIN `chat_accounts`
            WHERE (
                `timestamp` >= ( UNIX_TIMESTAMP( ) - 45)
                AND channel = ?
                AND `chat_users_online`.`user` = `chat_accounts`.`id`
                )";
        return DB::select($sql, array($channel));
    }
    // update online status of given user on given channel
    static function updateOnline($channel, $userId) {
            if ($userId !== 94) {
                $sql = 'INSERT INTO `chat_users_online`
                    (user,timestamp,channel)
                    VALUES (?,UNIX_TIMESTAMP(),?)
                    ON DUPLICATE KEY UPDATE timestamp=UNIX_TIMESTAMP()';
                DB::statement($sql, array($userId, $channel));
            }
    }
    // get level of permissions
    // -1  - banned
    // 0   - no access
    // 1   - normal user
    // 2   - moderator
    // 3   - admin
    static function getPermissionsLevel($channel, $userId) {
            $level = 0;
            if (!$userId)
                return 0; // niezalogowanie nie mają dostępu
            if ($channel == 255)
                return 1;
            $query = "SELECT SQL_CACHE * FROM `chat_access`
            WHERE
                `userid` = ?
                AND `channel` = ?
            LIMIT 1";
            $result = DB::select($query, array($userId, $channel));
	  //  var_dump(DB::getQueryLog(), $result);
            if (count($result) === 1) {
                $status = head($result);
                if ($status->banned > time()) {
                    $level = -1;
                }
                else {
                    $level =  $status->access;
                }
            }
            return $level;
    }
    // bans user and show message about this on channel
    static function banUser($channel, $bannedId, $time) {
            $query = 'UPDATE `ginden_rept`.`chat_access`
                SET
                    `banned` = (UNIX_TIMESTAMP()+?)
                WHERE
                    `chat_access`.`userid` = ?
                    AND `chat_access`.`access` < 2
                    AND `chat_access`.`channel` = ?';
            $result = DB::update($query, array($time, $bannedId, $time));
            if ($result == 1) {
                $query = 'SELECT `name` FROM `chat_accounts` WHERE `id` = ?';
                $result = DB::select($query, array($bannedId));
                $name = $result->name;
                $info_string = "Użytkownik ".$name." został zbanowany na okres ".Chat::secondsToNatural($time).'.';
                Chat::addMessage($channel, Chat::BOT_USER, $info_string);
                return true;
            }
            else {
                return true;
            }
    }
    static function getBannedUsers($channel) {
        $query = "SELECT
            `chat_access`.*,
            `chat_accounts`.`name`
            FROM
                `chat_access`
            INNER JOIN
                `chat_accounts`
            WHERE
                `chat_access`.`userid` = `chat_accounts`.`id`
                AND `chat_access`.`access` > 0
                AND `channel` = ?
                AND `banned` > UNIX_TIMESTAMP()
            ORDER BY
                `chat_accounts`.`name` ASC";
	return DB::select($query, array($channel));
    }
    static function getAllowedUsers($channel) {
        
    }
    static function getVisitsDates($channel) {
	$sql =  "SELECT SQL_CACHE
            `chat_accounts`.`name`,
            `chat_users_online`.`timestamp`
            FROM
                `chat_users_online`
            CROSS JOIN
                `chat_accounts`
            WHERE
	    (
                `timestamp` >= 0
                AND `timestamp` <= UNIX_TIMESTAMP()
            )
            AND
		channel = ?
            AND
		`chat_users_online`.`user` = `chat_accounts`.`id`
            ORDER BY
                `chat_users_online`.`timestamp` DESC
            ";
	return DB::select($sql, array($channel));
    }
    static function getChannels($all=false) {
        $query = "SELECT * FROM `chat_channels` ORDER BY `id`";
        $result = DB::select($query);
        $userId = CurrentUser::get()->id;
        $channels = array();
        foreach($result as $channel) {
                $access = self::getPermissionsLevel($channel->id, $userId);
                if ($all) {
                    $channel->access = $access;
                }
                if ($all || $access > 0) {
                    $channels[] = $channel;
                }
            }

        return $channels;
    }
    static function getModerators($channel) {
            $query = 'SELECT
                `chat_access`.*,
                `chat_accounts`.`name`
            FROM
                `chat_access`
            INNER JOIN
                `chat_accounts`
            WHERE
                `chat_access`.`userid` = `chat_accounts`.`id`
                AND `chat_access`.`access` > 1
                AND `channel` = ?
            ORDER BY
                `chat_accounts`.`name` ASC';
            $result = DB::select($query, array($channel));
            return $result;
    }
    static function getChannelInfo($channel) {
        $result = DB::select('SELECT
                *
            FROM
                `chat_channels`
            WHERE
                `id`= ?',
		array($channel));
        if (count($result) === 1) {
	    return $result[0];
	}
        if ($channel > 1000) {
            $reason = 'You weren\'t invited here.';
	}
        else {
            $reason = 'No channel like this.';
        }
	$ret = new ArrayObject(array(
		id => -1,
		img => '',
		short_decline => 'No access here.',
		long_decline  => $reason,
		), ArrayObject::STD_PROP_LIST);
	
        return $ret;
    }
    static function changePrivilages($channel, $userId, $level) {
	$query = 'INSERT INTO
                `chat_access`
                (`userid` ,`channel` ,`access` ,`banned`)
                VALUES
                (?,?,?, 0)
		ON DUPLICATE KEY
                    UPDATE `access`=?
		';
	DB::statement($query, array($userId, $channel, $level, $level));
    }
    static function getUsersWithoutAccess($channel) {
            $query1 = 'SELECT
                `id`,
                `name`
            FROM
                `chat_accounts`
            ORDER BY
                `name`';
            $result1 = DB::select($query1);
            $query2 = 'SELECT
                *
            FROM
                `chat_access`
            WHERE
                `channel` = ?
                AND `access` > 0';
            $result2 = DB::select($query2);
            $array1 = array();
            foreach($result2 as $row) {
                $f = $row->userid;
                $array1[''.$f] = $row;
            }
            foreach($result1 as $row) {
                $userid = $row->id;
                if (!$array1[$userid]) {
                    $array2[] = $row;
                }
            }
            return $array2;
    }
    static function createChannel($name, $id, $img='', $shortDecline, $longDecline) {
	$query = 'INSERT INTO `chat_channels`
	    (`id`, `name`, `img`, `short_decline`, `long_decline`)
	    VALUES (?,?,?,?,?)';
	DB::insert($query, array($id, $name, $img, $shortDecline, $longDecline));
    }
}
    


?>