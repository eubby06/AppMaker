<?php namespace Sam\Services\Installer;

class InstallerServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app['installer'] = $this->app->share(function($app)
		{
			return new \Sam\Services\Installer\Installer();
		});
	}

}
