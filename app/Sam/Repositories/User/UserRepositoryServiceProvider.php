<?php namespace Sam\Repositories\User;

use Sam\Repositories\User\UserRepository,
	CoreUser;

class UserRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('Sam\Repositories\User\UserRepositoryInterface', function($app)
		{
			return new UserRepository( new CoreUser );
		});
	}

}
