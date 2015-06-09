<?php namespace Sam\Helpers;

use Sam\Helpers\ResourceCounter;

class ResourceCounterServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app['ResourceCounter'] = $this->app->share(function($app)
		{
			$appRepo = $app->make('Sam\Repositories\App\AppRepositoryInterface');
			$moduleRepo = $app->make('Sam\Repositories\Module\ModuleRepositoryInterface');
			return new ResourceCounter($appRepo, $moduleRepo);
		});
	}

}
