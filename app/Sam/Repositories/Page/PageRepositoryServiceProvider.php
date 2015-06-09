<?php namespace Sam\Repositories\Page;

use Sam\Repositories\Page\PageRepository,
	CorePage;

class PageRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('Sam\Repositories\Page\PageRepositoryInterface', function($app)
		{
			return new PageRepository( new CorePage );
		});
	}

}
