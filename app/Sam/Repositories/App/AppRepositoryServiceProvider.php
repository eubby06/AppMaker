<?php namespace Sam\Repositories\App;

use Sam\Repositories\App\AppRepository,
	Sam\Repositories\User\UserRepository,
	CoreApp,
	CoreUser;

class AppRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('Sam\Repositories\App\AppRepositoryInterface', function($app)
		{
			return new AppRepository( new CoreApp, new UserRepository( new CoreUser ) );
		});
	}

}
