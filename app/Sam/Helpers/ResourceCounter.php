<?php namespace Sam\Helpers;

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;

class ResourceCounter {

	public $appRepo;
	public $moduleRepo;

	public $appCount;
	public $moduleCount;

	public function __construct(AppRepositoryInterface $appRepo, ModuleRepositoryInterface $moduleRepo)
	{
		$this->appRepo = $appRepo;
		$this->moduleRepo = $moduleRepo;

		$this->appCount = $this->appRepo->findAll()->count();
		$this->moduleCount = $this->moduleRepo->findAll()->count();
	}

	public function apps()
	{
		return $this->appCount;
	}

	public function modules()
	{
		return $this->moduleCount;
	}

}