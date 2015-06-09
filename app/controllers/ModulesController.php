<?php

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Page\PageRepositoryInterface;

class modulesController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $script = 'modules.script';
	protected $resource = 'modules';

	public function __construct(
		AppRepositoryInterface $appRepo, 
		ModuleRepositoryInterface $moduleRepo, 
		UserRepositoryInterface $userRepo,
		PageRepositoryInterface $pageRepo)
	{
		parent::__construct($appRepo, $moduleRepo, $userRepo, $pageRepo);
	}

	public function getIndex()
	{

		$modules = $this->moduleRepo->findAll();

		$this->layout->content = View::make('modules.index')->with('modules', $modules);	

		return $this->layout;
	}

	public function getCreate()
	{

		$this->layout->content = View::make('modules.create');	

		return $this->layout;
	}

	public function postCreate()
	{
		if($this->moduleRepo->validate(Input::all()))
		{

			$this->moduleRepo->create(Input::all());

			Session::flash('message', 'Module has been created successfully!');
			return Redirect::route( 'get.modules.list');
		}

		return Redirect::back()->withInput()->withErrors( $this->moduleRepo->validatorInstance() );
	}

	public function getEdit($id)
	{

		$module = $this->moduleRepo->findById($id);

		$this->layout->content = View::make('modules.edit')->with('module', $module);	

		return $this->layout;
	}

	public function postEdit($id)
	{
		if($this->moduleRepo->validate(Input::all()))
		{

			$this->moduleRepo->update(Input::all(), $id);

			Session::flash('message', 'Module has been updated successfully!');
			return Redirect::route( 'get.modules.list');
		}

		return Redirect::back()->withInput()->withErrors( $this->moduleRepo->validatorInstance() );
	}
}