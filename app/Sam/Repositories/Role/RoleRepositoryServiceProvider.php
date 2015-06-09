<?php namespace Sam\Repositories\Role;

use Sam\Repositories\Role\RoleRepository,
	CoreUser,
	CoreRole;

class RoleRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('Sam\Repositories\Role\RoleRepositoryInterface', function($app)
		{
			return new RoleRepository( new CoreRole, new CoreUser );
		});
	}

}
