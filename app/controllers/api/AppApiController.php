<?php

use Sam\Repositories\App\AppRepository as AppRepository;

class AppApiController extends Controller {

	public $AppRepository;

	public function __construct(AppRepository $AppRepository)
	{
		$this->AppRepository = $AppRepository;
	}

	public function getApp($id)
	{
		return $this->AppRepository->findById($id);
	}

	public function getModules($appId)
	{
		return $this->AppRepository->getModules($appId);
	}
}