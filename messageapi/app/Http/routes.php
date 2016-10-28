<?php

/****************   Model binding into route **************************/
Route::model('message', 'App\Message');
Route::pattern('slug', '[0-9a-z-_]+');

/***************    Site routes  **********************************/
Route::get('/', 'HomeController@index');

//Route::get('message', 'MessageController@index');
Route::get('message/{slug}', 'MessageController@show');
Route::get('message/decode/text', 'MessageController@decode');
Route::resource('message', 'MessageController');
Route::get('home', 'HomeController@index');
