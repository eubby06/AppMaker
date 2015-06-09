<?php

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Page\PageRepositoryInterface;

class BaseController extends Controller {

	public $ac;
	public $currentUser;
	public $manageOnlyUser = false;

	public $appRepo;
	public $moduleRepo;
	public $userRepo;
	public $pageRepo;

	public function __construct(AppRepositoryInterface $appRepo, 
		ModuleRepositoryInterface $moduleRepo, 
		UserRepositoryInterface $userRepo,
		PageRepositoryInterface $pageRepo)
	{
		$this->ac = App::make('AccessControl');
		$this->currentUser = $this->ac->getUser();

		$this->appRepo = $appRepo;
		$this->moduleRepo = $moduleRepo;
		$this->userRepo = $userRepo;
		$this->pageRepo = $pageRepo;

		//know the type of the current logged in user
		$this->manageOnlyUser = !$this->currentUser->hasAdminRights() ? true : false;
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

		$this->renderSidebar();
	}

	protected function renderSidebar()
	{
		//get sidebar template for logged in user
		if($this->manageOnlyUser)
		{
			$menu = $this->userRepo->getAppsAndManageableModules($this->currentUser);
			$this->layout->sidebarLeft = View::make('sidebars.manage')->with('menu',$menu);
		}
		else
		{
			//detemine the sidebar to display
			$types = $this->ac->getTypesDropdownForm();
			$this->layout->sidebarLeft = View::make('sidebars.admin')
											->with('types', $types)
											->with('resource', $this->resource);		
		}
		

		if ( ! is_null($this->script))
		{
			$this->layout->script = View::make($this->script);
		}							
	}
}
