<?php namespace Sam\Services\ExternalContentGrabber;

class ExternalContentGrabberServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app['ExternalContentGrabber'] = $this->app->share(function($app)
		{
			return new \Sam\Services\ExternalContentGrabber\FacebookContentGrabber();
		});
	}

}
