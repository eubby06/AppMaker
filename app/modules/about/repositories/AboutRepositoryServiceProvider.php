<?php namespace App\Modules\About\Repositories;

use App\Modules\About\Models\ModuleAbout;

class AboutRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('App\Modules\About\Repositories\AboutRepositoryInterface', function($app)
		{
			return new AboutRepository( new ModuleAbout);
		});
	}

}
