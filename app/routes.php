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

Route::get('/', function()
{
    //return Countries::getList('en', 'json', 'cldr');
    return Countries::getOne('RU', 'en', 'cldr');
});

Route::get('/jcrop', function() {

	return View::make('test.jcrop');
});

/*
Route::get('/', function() {

	$app = App::make('Sam\Repositories\App\AppRepositoryInterface');

	$apps = $app->findAll()->toArray();
 
	try {
	 	foreach($apps as $app) {

	 		MongoApp::create($app);

	 	}

	} catch(Exception $e) {

	 	DB::reconnect('mongodb');

	}
	
	

	try {

	 	$app = MongoApp::find('15a765774c5d74b61afa39c62a5b64ce');

	} catch(Exception $e) {

	 	DB::reconnect('mongodb');
	 	
	 	$app = MongoApp::find('15a765774c5d74b61afa39c62a5b64ce');
	}

	$module = $app->modules->first();

	return $app->modules;
	
});
*/

Route::get('build/{output}', function($output)
{
	$queue = Queue::push('Sam\Services\Builder\BuilderQueue', array('output' => $output));
	return $queue;
});

Route::get('download', function()
{
	//SSH::into('production')->get('~/sam.apk', '/home/vagrant/sam.apk');
});

//login and logout route
Route::get('login', array(
	'as' 	=> 'get.login.index', 
	'uses' 	=> 'LoginController@getIndex'
	));

Route::post('login', array(
	'as' 	=> 'post.login.index', 
	'uses' 	=> 'LoginController@postIndex'
	));

Route::get('logout', array(
	'as' 	=> 'get.login.logout', 
	'uses' 	=> 'LoginController@getLogout'
	));

Route::get('users/activate/{id}', array(
		'as' 	=> 'get.users.activate', 
		'uses' 	=> 'UsersController@getActivate'
	));

Route::get('users/request/{something}', array(
		'as' 	=> 'get.users.request', 
		'uses' 	=> 'LoginController@getRequest'
		));
Route::post('users/request/{something}', array(
		'as' 	=> 'post.users.request', 
		'uses' 	=> 'LoginController@postRequest'
	));
Route::get('users/reset/{resetCode}', array(
		'as' 	=> 'get.users.reset', 
		'uses' 	=> 'LoginController@getReset'
		));
Route::post('users/reset', array(
		'as' 	=> 'post.users.reset', 
		'uses' 	=> 'LoginController@postReset'
	));

//get language
$languages = array('en','zh');
$lang = in_array( Request::segment(1), $languages ) ? Request::segment(1) : 'en';
App::setLocale($lang);

Route::group(array('prefix' => $lang, 'before' => 'auth'), function()
{
	//Users
	Route::get('dashboard', array(
		'as' 	=> 'get.dashboard.index', 
		'uses' 	=> 'DashboardController@getIndex'
		));
	//Users
	Route::get('users', array(
		'as' 	=> 'get.users.list', 
		'uses' 	=> 'UsersController@getIndex'
		));
	Route::get('users/create', array(
		'as' 	=> 'get.users.create', 
		'uses' 	=> 'UsersController@getCreate'
		));
	Route::post('users/create', array(
		'as' 	=> 'post.users.create', 
		'uses' 	=> 'UsersController@postCreate'
		));
	Route::get('users/edit/{id}', array(
		'as' 	=> 'get.users.edit', 
		'uses' 	=> 'UsersController@getEdit'
		));
	Route::post('users/edit/{id}', array(
		'as' 	=> 'post.users.edit', 
		'uses' 	=> 'UsersController@postEdit'
		));
	Route::get('users/delete/{id}', array(
		'as' 	=> 'get.users.delete', 
		'uses' 	=> 'UsersController@getDelete'
		));

	//Permissions
	Route::get('permissions', array(
		'as' 	=> 'get.permissions.list', 
		'uses' 	=> 'PermissionsController@getIndex'
		));

	Route::post('permissions/assign', array(
		'as' 	=> 'post.permissions.assign', 
		'uses' 	=> 'PermissionsController@postAssign'
		));

	//Roles
	Route::get('roles', array(
		'as' 	=> 'get.roles.list', 
		'uses' 	=> 'RolesController@getIndex'
		));
	Route::get('roles/create', array(
		'as' 	=> 'get.roles.create', 
		'uses' 	=> 'RolesController@getCreate'
		));
	Route::post('roles/create', array(
		'as' 	=> 'post.roles.create', 
		'uses' 	=> 'RolesController@postCreate'
		));
	Route::get('roles/edit/{id}', array(
		'as' 	=> 'get.roles.edit', 
		'uses' 	=> 'RolesController@getEdit'
		));
	Route::post('roles/edit/{id}', array(
		'as' 	=> 'post.roles.edit', 
		'uses' 	=> 'RolesController@postEdit'
		));
	Route::get('roles/delete/{id}', array(
		'as' 	=> 'get.roles.delete', 
		'uses' 	=> 'RolesController@getDelete'
		));
	Route::get('roles/users/{id}', array(
		'as' 	=> 'get.roles.users', 
		'uses' 	=> 'RolesController@getUsers'
		));
	Route::get('roles/remove/users', array(
		'as' 	=> 'get.roles.remove.user', 
		'uses' 	=> 'RolesController@getRemove'
		));
	Route::post('roles/remove/users', array(
		'as' 	=> 'post.roles.remove.user', 
		'uses' 	=> 'RolesController@postRemove'
		));
	Route::post('roles/add/users', array(
		'as' 	=> 'post.roles.add.user', 
		'uses' 	=> 'RolesController@postAdd'
		));

	//Applications

	Route::get('apps', array(
		'as' 	=> 'get.apps.list', 
		'uses' 	=> 'AppsController@getIndex'
		));

	Route::get('apps/create', array(
		'as' 	=> 'get.apps.create', 
		'uses' 	=> 'AppsController@getCreate'
		));

	Route::post('apps/create', array(
		'as' 	=> 'post.apps.create', 
		'uses' 	=> 'AppsController@postCreate'
		));

	Route::get('apps/edit/{id}', array(
		'as' 	=> 'get.apps.edit', 
		'uses' 	=> 'AppsController@getEdit'
		));

	Route::post('apps/edit/{id}', array(
		'as' 	=> 'post.apps.edit', 
		'uses' 	=> 'AppsController@postEdit'
		));

	Route::get('apps/{id}/dashboard', array(
		'as' 	=> 'get.apps.dashboard', 
		'uses' 	=> 'AppsController@getDashboard'
		));

	//Push Notifications
	Route::get('apps/{id}/notifications', array(
		'as' 	=> 'get.apps.notifications', 
		'uses' 	=> 'NotificationsController@getIndex'
		));

	Route::post('apps/{id}/notifications', array(
		'as' 	=> 'post.apps.notifications', 
		'uses' 	=> 'NotificationsController@postIndex'
		));

	//Modules
	Route::get('modules', array(
		'as' 	=> 'get.modules.list', 
		'uses' 	=> 'ModulesController@getIndex'
		));

	Route::get('modules/create', array(
		'as' 	=> 'get.modules.create', 
		'uses' 	=> 'ModulesController@getCreate'
		));

	Route::post('modules/create', array(
		'as' 	=> 'post.modules.create', 
		'uses' 	=> 'ModulesController@postCreate'
		));

	Route::get('modules/edit/{id}', array(
		'as' 	=> 'get.modules.edit', 
		'uses' 	=> 'ModulesController@getEdit'
		));

	Route::post('modules/edit/{id}', array(
		'as' 	=> 'post.modules.edit', 
		'uses' 	=> 'ModulesController@postEdit'
		));
});

/*
Route::group(array('prefix' => 'image'), function()
{
	Route::post('upload', array(
		'as' 	=> 'post.image.upload', 
		'uses' 	=> 'ImageController@postUpload'
		));
	Route::post('crop', array(
		'as' 	=> 'post.image.crop', 
		'uses' 	=> 'ImageController@postCrop'
		));
});

Route::group(array('prefix' => 'apps'), function()
{
	Route::get('/', array(
		'as' 	=> 'get.apps.list', 
		'uses' 	=> 'AppController@getIndex'
		));
	Route::get('dashboard/{package_name}', array(
		'as' 	=> 'get.apps.dashboard', 
		'uses' 	=> 'AppController@getDashboard'
		));
	Route::get('delete/{package_name}', array(
		'as' 	=> 'get.apps.delete', 
		'uses' 	=> 'AppController@getDelete'
		));
	Route::get('create', array(
		'as' 	=> 'get.apps.create', 
		'uses' 	=> 'AppController@getCreate'
		));
	Route::post('create', array(
		'as' 	=> 'post.apps.create', 
		'uses' 	=> 'AppController@postCreate'
		));
	Route::get('edit/{package_name}', array(
		'as' 	=> 'get.apps.edit', 
		'uses' 	=> 'AppController@getEdit'
		));
	Route::post('add/module', array(
		'as' 	=> 'post.apps.add.module', 
		'uses' 	=> 'AppController@postAddModule'
		));
	Route::post('delete/module', array(
		'as' 	=> 'post.apps.delete.module', 
		'uses' 	=> 'AppController@postDeleteModule'
		));
	Route::post('edit/module', array(
		'as' 	=> 'post.apps.edit.module', 
		'uses' 	=> 'AppController@postEditModule'
		));
});

Route::group(array('prefix' => 'modules'), function()
{
	Route::get('/', array(
		'as' 	=> 'get.modules.list', 
		'uses' 	=> 'ModulesController@getIndex'
		));
	Route::get('modules', array(
		'as' 	=> 'get.modules.create', 
		'uses' 	=> 'ModulesController@getCreate'
		));
	Route::post('modules', array(
		'as' 	=> 'post.modules.create', 
		'uses' 	=> 'ModulesController@postCreate'
		));
});
*/

Route::group(array('prefix' => 'api'), function()
{
	Route::get('roles', 'RoleApiController@getIndex');
	Route::post('notifications', 'NotificationApiController@postIndex');
	Route::post('notifications/queue/process', function()
	{
	    return Queue::marshal();
	});
});

Route::get('queue/send', function()
	{
	    Queue::push('WriteFile', array('string'=>'Hello World'));

	    return 'ok';
	});

class WriteFile {

	public function fire($job, $data)
	{
		File::append(__DIR__.'/queue.txt', $data['string'].PHP_EOL);

	       $job->delete();
	}

}

