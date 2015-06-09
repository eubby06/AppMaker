<?php

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Page\PageRepositoryInterface;

class DashboardController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $script = 'dashboard.script';
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

		$this->layout->content = View::make('dashboard.index');

		return $this->layout;
	}

}