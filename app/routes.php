<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', array(
                 'as' =>    'home',
                 'uses' => 'LoginController@start')
           );

Route::get('/login/',
           array(
                'before' => 'guest',
                 'as' =>    'login',
                 'uses' => 'LoginController@loginForm'
                 )
           );

Route::get('/logout/{token}/',
           array(
                'before' => 'auth',
                 'as' =>    'logout',
                 'uses' => 'LoginController@logOut'
                 )
           );

Route::post('/login-data/', array(
                              //    'before' => 'csrf|guest',
                                  'as' => 'login.post',
                                  'uses' => 'LoginController@loginHandle'));

Route::get('/channel/{channel}/', array(
                'before' => 'auth|auth.chat.basic',
                'as'   =>    'channel.get',
                'uses' => 'ChatController@channel'
                 )
           )->where('channel', '[0-9]+');

Route::any('/channel/{channel}/messages/', array(
                 'before' => 'auth|auth.chat.basic',
                 'as' =>    'channel.messages',
                 'uses' =>  'ChatController@messages'
                 )
           )->where('channel', '[0-9]+');

Route::any('/channel/{channel}/add-message/', array(
                    'before' => 'auth|auth.chat.basic',
                 'as' =>    'channel.addMessage',
                 'uses' =>  'ChatController@addMessage'
                 )
           )->where('channel', '[0-9]+');

Route::any('/channel/{channel}/online/', array(
                    'before' => 'auth|auth.chat.basic',
                 'as' =>    'channel.getUsers',
                 'uses' =>  'ChatController@showMembers'
                 )
           )->where('channel', '[0-9]+');

Route::any('/channel/{channel}/moderation/ban-user/', array(
                    'before' => 'auth|auth.chat.mod',
                 'as' =>    'channel.banUser',
                 'uses' =>  'ChatModController@banUser'
                 )
           )->where('channel', '[0-9]+');

Route::any('/channel/{channel}/moderation/show-bans/', array(
                'before' => 'auth|auth.chat.mod',
                 'as' =>    'channel.getUsers',
                 'uses' =>  'ChatModController@showBans'
                 )
           )->where('channel', '[0-9]+');

Route::any('/channels', array(
                'before' => 'auth',
                'as' => 'channels.list',
                'uses' => 'ChatController@listChannels'
            ));
          
Route::any('/channel/{channel}/moderation/show-users/',
           array(
                'before' => 'auth.chat.mod',
                 'as' =>    'channel.moderation.showUsers',
                 'uses' => 'ChatModController@showUsers')
           )->where('channel', '[0-9]+');
Route::any('/channel/{channel}/moderation/give-access/',            array(
                'before' => 'auth.chat.mod',
                 'as' =>    'channel.moderation.giveAccess',
                 'uses' => 'ChatModController@giveAccess'))->where('channel', '[0-9]+');
Route::any('/channel/{channel}/moderation/last-seen/',            array(
                'before' => 'auth.chat.mod',
                 'as' =>    'channel.moderation.lastSeen',
                 'uses' => 'ChatModController@lastSeen'))->where('channel', '[0-9]+');
Route::get('/rank/', array(
                 'as' =>    'rank',
                 'uses' =>  'RankController@base'
                 )
           );
Route::any('/profile/my', array(
                                'before'=> 'auth',
                                'as'    => 'profile.my',
                                'uses'  => 'ProfileController@showMyProfile'
                                ));

Route::any('/profile/{profile}', array(
                                'as'    => 'profile.show',
                                'uses'  => 'ProfileController@showMyProfile'
                                ))->where('profile', '[0-9]+');

Route::get('/migrate', array(
                                'as'    => 'profile.migrateLogin',
                                'uses'   => 'ProfileController@getMigrateLoginType'
                            ));

Route::post('/migrate', array(
                                'as'    => 'profile.migrateLogin',
                                'uses'   => 'ProfileController@postMigrateLoginType'
                            ));

Route::get('/profile/edit', array(
                                'as'    => 'profile.edit',
                                'uses'   => 'ProfileController@getEditProfile'
                            ));

Route::post('/profile/edit', array(
                                'as'    => 'profile.editSend',
                                'uses'   => 'ProfileController@postEditProfile'
                            ));