<?php namespace App\Modules\Contact\Controllers;

use Sam\Repositories\App\AppRepositoryInterface,
	Sam\Repositories\Module\ModuleRepositoryInterface,
	App\Modules\Contact\Repositories\ContactRepositoryInterface,
	Controller,
	View,
	Input,
	App\Modules\ModuleController,
	Redirect;

class ContactController extends ModuleController {

	public $contactRepo;

	public function __construct(
		AppRepositoryInterface $appRepo, 
		ModuleRepositoryInterface $moduleRepo,
		ContactRepositoryInterface $contactRepo)
	{
		parent::__construct($appRepo, $moduleRepo);

		// module initialization here ...
		$this->contactRepo = $contactRepo;
	}

	public function getIndex($packageName, $moduleKey, $pageId)
	{
		// module being edited
		$editModule = $this->moduleRepo->findByKey($moduleKey);

		// get fields and values of the module being edited
		$fields = $this->contactRepo->fieldsAndValue($pageId);

		// partial view for contact page module
		$this->layout->module = View::make('contact::index')
										->with('pageId', $pageId)
										->with('module', $editModule)
										->with('fields', $fields);

		$this->layout->script = View::make('contact::script');

		// this set up the header and a sidebar
		$this->_setLayout($packageName, $moduleKey);

		return $this->layout;
	}

	// use for ajax request
	public function geData($packageName, $moduleKey)
	{
		return $this->moduleRepo->findByKey($moduleKey);
	}

	// use for ajax request
	public function geFields($packageName, $moduleKey)
	{
		return $this->moduleRepo->findByKey($moduleKey);
	}

	public function postData($pageId)
	{
		$this->contactRepo->saveFields($pageId, Input::all());

		return 'success';
	}
}