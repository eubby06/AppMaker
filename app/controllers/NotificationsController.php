<?php

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Role\RoleRepositoryInterface;
use Sam\Repositories\Page\PageRepositoryInterface;

class NotificationsController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $script = 'notifications.script';
	protected $resource = 'apps';

	public $roleRepo;

	public function __construct(
		RoleRepositoryInterface $roleRepo,
		AppRepositoryInterface $appRepo, 
		ModuleRepositoryInterface $moduleRepo, 
		UserRepositoryInterface $userRepo,
		PageRepositoryInterface $pageRepo)
	{
		parent::__construct($appRepo, $moduleRepo, $userRepo, $pageRepo);

		$this->roleRepo = $roleRepo;
	}

	public function getIndex($id)
	{
		$countries = Countries::getList('en', 'json', 'cldr');
		$roles = $this->roleRepo->findByAppId($id);

		$this->layout->content = View::make('notifications.index')
										->with('roles', dropdownFormat($roles))
										->with('appId', $id)
										->with('countries', json_decode($countries));
										
		$app = $this->appRepo->findById($id);
		$this->layout->sidebarLeft = View::make('sidebars.app')
											->with('app', $app);

		return $this->layout;
	}

}