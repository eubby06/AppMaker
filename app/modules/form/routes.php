<?php

//get language
$languages = array('en','zh');
$lang = in_array( Request::segment(1), $languages ) ? Request::segment(1) : 'en';
App::setLocale($lang);

Route::group(array('prefix' => $lang, 'before' => 'auth'), function()
{
	//return View::make('form::index');

	Route::get('apps/{appId}/manage/form', array(
		'as' 	=> 'get.module.form.index', 
		'uses' 	=> 'App\Modules\Form\Controllers\FormController@getIndex'
	));

	Route::post('apps/{appId}/manage/form', array(
		'as' 	=> 'post.module.form.index', 
		'uses' 	=> 'App\Modules\Form\Controllers\FormController@postIndex'
	));

	Route::get('apps/{appId}/manage/form/delete/{id}', array(
		'as' 	=> 'get.module.form.delete', 
		'uses' 	=> 'App\Modules\Form\Controllers\FormController@getDelete'
	));
});