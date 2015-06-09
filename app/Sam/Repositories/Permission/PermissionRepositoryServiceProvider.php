<?php namespace Sam\Repositories\Permission;

use Sam\Repositories\Permission\PermissionRepository,
	CorePermission;

class PermissionRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('Sam\Repositories\Permission\PermissionRepositoryInterface', function($app)
		{
			return new PermissionRepository( new CorePermission );
		});
	}

}
