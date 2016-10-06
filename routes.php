<?php

use WebKet\Main\Main;

Main::model('messages', 'Request\MessagesRequest\MessagesRequest');
Main::model('messagesview', 'Request\MessagesViewRequest\MessagesViewRequest');
Main::model('users', 'Request\UsersRequest\UsersRequest');
Main::model('usersupdate', 'Request\UsersUpdateRequest\UsersUpdateRequest');
Main::model('userslogin', 'Request\UsersLoginRequest\UsersLoginRequest');

Main::pattern('id', '[0-9]+');
Main::pattern('slug', '[0-9a-z-_]+');
Main::pattern('name', '[a-z-_]+');
Main::pattern('norequest', '');

Main::get('/', 'HomeController@index');
Main::get('/auth-login', 'UsersController@authlogin');
Main::get('/auth-logout', 'UsersController@authlogout');
Main::get('/auth-registration', 'UsersController@authregister');
Main::get('/login{@userslogin}', 'UsersController@login');
Main::get('/registration{@users}', 'UsersController@registration');
Main::get('/list-messages{@users}{norequest}', 'MessagesController@listmessages');
Main::get('/list-users{@users}{norequest}', 'UsersController@listusers');
Main::get('/delete-users\/{id}{@users}{norequest}', 'UsersController@deleteusers');
Main::get('/user-update{@usersupdate}', 'UsersController@update');
Main::get('/message-send{@messages}', 'MessagesController@messagesend');
Main::get('/view-messages\/{id}{@messagesview}{norequest}', 'MessagesController@viewmessages');
Main::get('/count-messages\/{id}{@messagesview}{norequest}', 'MessagesController@countmessages');
Main::view();