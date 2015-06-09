<?php namespace Sam\Services\AccessControl;

use Sam\Repositories\User\UserRepository,
 	Sam\Repositories\Role\RoleRepository,
	CoreUser,
	CoreRole;

class AccessControlServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app['AccessControl'] = $this->app->share(function($app)
		{
			$userRepo = new UserRepository( new CoreUser );
			$roleRepo = new RoleRepository( new CoreRole, new CoreUser );

			return new \Sam\Services\AccessControl\AccessControl($userRepo, $roleRepo);
		});
	}

}
