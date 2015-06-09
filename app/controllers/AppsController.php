<?php

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Page\PageRepositoryInterface;

class AppsController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $script = 'apps.script';
	protected $resource = 'apps';

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

		$apps = $this->appRepo->getRelevantApps($this->currentUser);

		$this->layout->content = View::make('apps.index')->with('apps', $apps);		

		return $this->layout;
	}

	public function getEdit($id)
	{

		$app = $this->appRepo->findById($id);
		$modules = $this->moduleRepo->getModuleIdsForDropdown();
		$merchants = $this->userRepo->getMerchantIdsForDropdown();
		$pages = $app->pages ? $app->pages : array();

		$this->layout->content = View::make('apps.edit')
										->with('app', $app)
										->with('modules', $modules)
										->with('pages', $pages)
										->with('merchants', $merchants);

		$app = $this->appRepo->findById($id);
		$this->layout->sidebarLeft = View::make('sidebars.app')
											->with('app', $app);

		return $this->layout;
	}

	public function postEdit($appId)
	{
		$newPageIds = array();

		if($pageIds = Input::get('page_ids'))
		{
			foreach($pageIds as $idAndName)
			{
				list($id,$name) = preg_split('/-/', $idAndName);

				//data for creation
				$data = array(
					'module_id' => $id,
					'app_id' => $appId,
					'name' => $name
					);
		
				//create a page and return page id
				$page = $this->pageRepo->create($data);

				// page ids to be saved in the app document
				$newPageIds[] = $page->id;
			}

			//get keys of the array and assign to page_ids
			Input::merge(array('page_ids' => $newPageIds));
		}

		if($this->appRepo->validate(Input::all()))
		{
			$this->appRepo->update(Input::all(), $appId);

			Session::flash('message', 'App has been updated successfully!');
			return Redirect::route( 'get.apps.list');
		}

		return Redirect::back()->withInput()->withErrors( $this->appRepo->validatorInstance() );
	}

	public function getCreate()
	{
		$merchants = $this->userRepo->getMerchantIdsForDropdown();

		$this->layout->content = View::make('apps.create')
										->with('merchants', array_merge($merchants, array('' => 'Select Merchant')));	

		return $this->layout;
	}

	public function postCreate()
	{
		if($this->appRepo->validate(Input::all()))
		{

			$this->appRepo->create(Input::all());

			Session::flash('message', 'App has been created successfully!');
			return Redirect::route( 'get.apps.list');
		}

		return Redirect::back()->withInput()->withErrors( $this->appRepo->validatorInstance() );
	}

	public function getDashboard($id)
	{
		$app = $this->appRepo->findById($id);

		$this->layout->content = View::make('apps.dashboard');

		$this->layout->sidebarLeft = View::make('sidebars.app')
											->with('app', $app);

		return $this->layout;
	}
}