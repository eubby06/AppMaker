<?php

//get language
$languages = array('en','zh');
$lang = in_array( Request::segment(1), $languages ) ? Request::segment(1) : 'en';
App::setLocale($lang);

Route::group(array('prefix' => $lang, 'before' => 'auth'), function()
{
	//return View::make('form::index');

	Route::get('apps/{appId}/manage/membership', array(
		'as' 	=> 'get.module.membership.index', 
		'uses' 	=> 'MembershipController@getIndex'
	));
});