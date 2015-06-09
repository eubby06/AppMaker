<?php namespace App\Modules\Contact\Repositories;

use App\Modules\Contact\Models\ModuleContact;

class ContactRepositoryServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{
		$this->app->bind('App\Modules\Contact\Repositories\ContactRepositoryInterface', function($app)
		{
			return new ContactRepository( new ModuleContact);
		});
	}

}
