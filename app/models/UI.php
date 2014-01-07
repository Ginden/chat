<?php

class UI {
    const APP_NAME      = 'chat Gindena';
    const APP_baseJS    = 'base.js';
    const APP_CDN       = 'http://static.ginden.pl/chat/';
    const GA_ACCOUNT    = 'UA-33776829-1';
    const APP_BASE      = 'http://chat2.ginden.pl/';
    
    private static function createMenuElement($href, $name, $class='') {
        return new ArrayObject(array(
            'href'  => $href,
            'name'  => $name,
            'class' => $class
        ));
    }
    public static function menu() {
        $result = [];
        if (ChatAuth::check()) {
            $result[] = self::createMenuElement(route('logout', array('token'=>Session::token())), 'wyloguj się');
            $result[] = self::createMenuElement(route('channels.list'), 'kanały');
            $channels = Chat::getChannels();
            foreach($channels as $channel) {
                    $result[] = self::createMenuElement(
                            route('channel.get', array('channel'=>$channel->id)), $channel->name, 'channel-link');
            }
        }
        else {
            $result[] = self::createMenuElement(route('login'), 'zaloguj się');
        }
        $result[] = self::createMenuElement(route('rank'), 'statystyki');
        return $result;
    }
}


?>