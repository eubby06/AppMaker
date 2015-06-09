<?php

use Sam\Repositories\Role\RoleRepositoryInterface;

class RoleApiController extends Controller {

	public $roleRepo;
	public $ac;
	public $currentUser;

	public function __construct(RoleRepositoryInterface $roleRepo)
	{
		$this->roleRepo = $roleRepo;
		$this->ac = App::make('AccessControl');
		$this->currentUser = $this->ac->getUser();
	}

	public function getIndex()
	{
		$merchantId = Input::get('merchantId') ? Input::get('merchantId') : null;

		if(is_null($merchantId))
		{
			$roles = $this->roleRepo->getRolesDropdownFormat($this->currentUser->id);
		}
		else
		{
			$roles = $this->roleRepo->getRolesDropdownFormat($merchantId);
		}

		return $roles;
	}
}	