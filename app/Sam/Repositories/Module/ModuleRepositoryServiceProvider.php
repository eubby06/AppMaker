<?php namespace Sam\Repositories\Module;

use Sam\Repositories\Module\ModuleRepository,
	CoreModule;

class ModuleRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('Sam\Repositories\Module\ModuleRepositoryInterface', function($app)
		{
			return new ModuleRepository( new CoreModule );
		});
	}

}
