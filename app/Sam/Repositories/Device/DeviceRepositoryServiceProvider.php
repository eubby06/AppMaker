<?php namespace Sam\Repositories\Device;

use Sam\Repositories\Device\DeviceRepositoryInterface,
	CoreUser,
	CoreRole,
	CoreDevice;

class DeviceRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('Sam\Repositories\Device\DeviceRepositoryInterface', function($app)
		{

			return new DeviceRepository(new CoreDevice, new CoreUser, new CoreRole);
		});
	}

}
