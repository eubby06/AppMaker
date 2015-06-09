<?php namespace App\Modules\About\Controllers;

use Sam\Repositories\App\AppRepositoryInterface,
	Sam\Repositories\Module\ModuleRepositoryInterface,
	App\Modules\About\Repositories\AboutRepositoryInterface,
	Controller,
	View,
	Input,
	App\Modules\ModuleController,
	Redirect;

class AboutController extends ModuleController {

	public $aboutRepo;

	public function __construct(
		AppRepositoryInterface $appRepo, 
		ModuleRepositoryInterface $moduleRepo,
		AboutRepositoryInterface $aboutRepo)
	{
		parent::__construct($appRepo, $moduleRepo);

		// module initialization here ...
		$this->aboutRepo = $aboutRepo;
	}

	public function getIndex($packageName, $moduleKey, $pageId)
	{
		// module being edited
		$editModule = $this->moduleRepo->findByKey($moduleKey);

		// get fields and values of the module being edited
		$fields = $this->aboutRepo->fieldsAndValue($pageId);

		// partial view for about page module
		$this->layout->module = View::make('about::index')
										->with('pageId', $pageId)
										->with('module', $editModule)
										->with('fields', $fields);

		$this->layout->script = View::make('about::script');

		// this set up the header and a sidebar
		$this->_setLayout($packageName, $moduleKey);

		return $this->layout;
	}

	// use for ajax request
	public function geFields($pageId)
	{
		//return $this->moduleRepo->findByKey($moduleKey);
		return $this->aboutRepo->fieldsAndValue($pageId);
	}

	// use for ajax request
	public function postFields($pageId)
	{
		$data = Input::all();

		$this->aboutRepo->saveFields($pageId, Input::all());

		return $data;		
	}
}