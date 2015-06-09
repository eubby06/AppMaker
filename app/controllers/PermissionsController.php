<?php

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Role\RoleRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Permission\PermissionRepositoryInterface;
use Sam\Repositories\Page\PageRepositoryInterface;

class PermissionsController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $script = 'permissions.script';
	protected $resource = 'permissions';

	public $permissionRepo;
	public $roleRepo;

	public function __construct(
		RoleRepositoryInterface $roleRepo,
		AppRepositoryInterface $appRepo, 
		ModuleRepositoryInterface $moduleRepo, 
		UserRepositoryInterface $userRepo, 
		PermissionRepositoryInterface $permissionRepo,
		PageRepositoryInterface $pageRepo)
	{
		parent::__construct($appRepo, $moduleRepo, $userRepo, $pageRepo);

		$this->permissionRepo = $permissionRepo;
		$this->roleRepo = $roleRepo;
	}

	public function getIndex()
	{
		//get role object
		$role = Input::get('role') ? $this->roleRepo->findById(Input::get('role')) : null;

		//get user object
		$user = Input::get('user') ? $this->userRepo->findById(Input::get('user')) : null;

		if(!is_null($user))
		{
			return $this->_listPermissionForUser($user);
		}

		if(!is_null($role))
		{
			return $this->_listPermissionForRole($role);
		}
	}

	public function _listPermissionForRole($role)
	{
		//if there's no user, then redirect back
		if(is_null($role))
		{
			return Redirect::route('get.roles.list');
		}

		//get role's merchant object
		$app = $role->app;

		//get private modules for role and manageable modules for merchants
		if($role->type == 'access')
		{
			$merchantAppsModules = $this->moduleRepo->getAppPrivateModules($app);
		}
		
		if($role->type == 'manage')
		{
			$merchantAppsModules = $this->moduleRepo->getAppManageableModules($app);
		}

		$this->layout->content = View::make('permissions.role')
										->with('role', $role)
										->with('data', $merchantAppsModules);

		return $this->layout;
	}

	public function _listPermissionForUser($user)
	{
		//if there's no user, then redirect back
		if(is_null($user))
		{
			return Redirect::route('get.users.list');
		}

		//get private modules for users and manageable modules for merchants
		if(!$user->hasAdminRights())
		{
			$merchantAppsModules = $this->moduleRepo->getMerchantPrivateModules($user);
		}
		
		if($user->isManager())
		{
			$merchantAppsModules = $this->moduleRepo->getMerchantManageablesModules($user);
		}

		$this->layout->content = View::make('permissions.user')
										->with('user', $user)
										->with('data', $merchantAppsModules);

		return $this->layout;
	}

	public function postAssign()
	{
		//get privileges if they exist
		$privileges = Input::get('privileges') ? Input::get('privileges') : null;

		//get role object
		$role = Input::get('role') ? $this->roleRepo->findById(Input::get('role')) : null;

		//get user object
		$user = Input::get('user') ? $this->userRepo->findById(Input::get('user')) : null;

		if(!is_null($role))
		{
			return $this->_assignRole($role, $privileges);
		}

		if(!is_null($user))
		{
			return $this->_assignUser($user, $privileges);
		}
	}

	public function _assignRole($role, $privileges)
	{
		if(!$role)
		{
			return Redirect::back();
		}

		if(!is_null($privileges))
		{
			$role->privileges = $privileges;
		}

		if($role->type == 'access')
		{
			$role->access_permissions = Input::get('modules');
			$role->save();

			Session::flash('message', 'Role\'s permissions updated successfully!');
			return Redirect::route( 'get.roles.list');
		}

		if($role->type == 'manage')
		{
			$role->manage_permissions = Input::get('modules');
			$role->save();

			Session::flash('message', 'Role\'s permissions updated successfully!');
			return Redirect::route( 'get.roles.list');
		}

		return Redirect::back();
	}

	public function _assignUser($user, $privileges)
	{
		if(!$user)
		{
			return Redirect::back();
		}

		if(!is_null($privileges))
		{
			$user->privileges = $privileges;
		}

		//this is for user who only have manage rights
		if(!$user->hasAdminRights())
		{
			$user->access_permissions = Input::get('modules');
			$user->save();

			Session::flash('message', 'User\'s permissions updated successfully!');
			return Redirect::route( 'get.users.list');
		}

		if($user->isManager())
		{
			$user->manage_permissions = Input::get('modules');
			$user->save();

			Session::flash('message', 'User\'s permissions updated successfully!');
			return Redirect::route( 'get.users.list');
		}

		return Redirect::back();
	}
	
}