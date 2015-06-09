<?php

use Sam\Repositories\Role\RoleRepositoryInterface;
use Sam\Repositories\Permission\PermissionRepositoryInterface;
use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Page\PageRepositoryInterface;

class RolesController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $script = 'roles.script';
	protected $resource = 'roles';

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
		$roles = array();

		//is var search available
		$search = Input::get('search') ? Input::get('search') : null;

		//$roles = $this->roleRepo->getRoles($search, null, true);

		$roles = $this->roleRepo->getRoles($this->currentUser->id, $search, 10);

		$this->layout->content = View::make('roles.index')
										->with('roles', $roles)
										->with('user', $this->currentUser);

		return $this->layout;
	}

	public function getCreate()
	{
		//check current user role
		if($this->currentUser->isSuper()) 
		{
			$merchants = $this->userRepo->getMerchantIdsForDropdown();
		}
		else if($this->currentUser->isAdmin())
		{
			$merchants = $this->userRepo->getMerchantIdsForDropdown($this->currentUser->_id);
		}
		else
		{
			$merchants = array(''.$this->currentUser->_id.'' => $this->currentUser->fullname());
		}
		
		$apps = $this->appRepo->getRelevantAppsDropdownFormat($this->currentUser);

		$dropdownFirstValue = array('' => 'Please select...');

		$this->layout->content = View::make('roles.create')
										->with('currentUser', $this->currentUser)
										->with('apps', array_merge($dropdownFirstValue, $apps))
										->with('merchants', array_merge($dropdownFirstValue, $merchants));

		return $this->layout;
	}

	public function postCreate()
	{
		if($this->roleRepo->validate(Input::all()))
		{
			$this->roleRepo->create(Input::all());

			Session::flash('message', 'Role has been created successfully!');
			return Redirect::route( 'get.roles.list');
		}

		return Redirect::back()->withInput()->withErrors( $this->roleRepo->validatorInstance() );
	}

	public function getEdit($id)
	{
		$role = $this->roleRepo->findById($id);

		//check current user role
		if($this->currentUser->isSuper()) 
		{
			$merchants = $this->userRepo->getMerchantIdsForDropdown();
		}
		else if($this->currentUser->isAdmin())
		{
			$merchants = $this->userRepo->getMerchantIdsForDropdown($this->currentUser->_id);
		}
		else
		{
			$merchants = array(''.$this->currentUser->_id.'' => $this->currentUser->fullname());
		}
		
		$apps = $this->appRepo->getRelevantAppsDropdownFormat($this->currentUser);

		$dropdownFirstValue = array('' => 'Please select...');

		$this->layout->content = View::make('roles.edit')
										->with('role', $role)
										->with('currentUser', $this->currentUser)
										->with('apps', array_merge($dropdownFirstValue, $apps))
										->with('merchants', array_merge($dropdownFirstValue, $merchants));

		return $this->layout;
	}

	public function postEdit($id)
	{
		if($this->roleRepo->validate(Input::all()))
		{

			$this->roleRepo->update(Input::all(), $id);

			Session::flash('message', 'Role has been updated successfully!');
			return Redirect::route( 'get.roles.list');
		}

		return Redirect::back()->withInput()->withErrors( $this->roleRepo->validatorInstance() );
	}

	public function getDelete($id)
	{
		$role = $this->roleRepo->findById($id);

		if ($role) 
		{
			$role->delete();
		}

		Session::flash('message', 'Role has been deleted successfully!');
		return Redirect::back();
	}

	public function getUsers($roleId)
	{
		$role = $this->roleRepo->findById($roleId);

		try{
			$users = $role->users()->paginate(10);
		}
		catch(exception $e) {
			$users = array();
		}

		try{
			$allUsers = $role->merchant->users;
		}
		catch(exception $e) {
			$allUsers = array();
		}

		//excluding users who are already in the list
		$dropdownAllUsers = dropdownFormat($allUsers);	
		$filteredUsers = $dropdownAllUsers;

		if(!empty($users))
		{
			$dropdownUser = dropdownFormat($users);
			$filteredUsers = (count($dropdownAllUsers) > count($dropdownUser)) ? array_diff($dropdownAllUsers, $dropdownUser) : array_diff($dropdownUser, $dropdownAllUsers);	
		}

		$this->layout->content = View::make('roles.users')
										->with('role', $role)
										->with('users', $users)
										->with('filteredUsers', $filteredUsers);

		return $this->layout;
	}

	//remove a user from a particular role
	public function getRemove()
	{
		$role = $this->roleRepo->findById(Input::get('role'));

		if(!Input::get('role') && !Input::get('user'))
		{
			Session::flash('message', 'Oops! this is an invalid request.');
			return Redirect::back();	
		}

		$role->removeUser(Input::get('user'));

		Session::flash('message', 'User has been removed from the group successfully!');
		return Redirect::back();
	}

	//remove selected users from a particular role
	public function postRemove()
	{
		$users = Input::get('users');
		$role = $this->roleRepo->findById(Input::get('role'));

		if($users && $role)
		{
			$role->removeUsers($users);
		}

		Session::flash('message', 'Users has been removed from the group successfully!');
		return Redirect::back();
	}

	//add a user to a particular role
	public function postAdd()
	{
		$role = $this->roleRepo->findById(Input::get('role'));

		if(!Input::get('role') && !Input::get('user'))
		{
			Session::flash('message', 'Oops! this is an invalid request.');
			return Redirect::back();	
		}

		$role->addUser(Input::get('user'));

		Session::flash('message', 'User has been added to the group successfully!');
		return Redirect::back();
	}
}