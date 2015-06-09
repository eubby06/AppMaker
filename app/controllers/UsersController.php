<?php

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Role\RoleRepositoryInterface;
use Sam\Repositories\Page\PageRepositoryInterface;

class UsersController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $script = 'users.script';
	protected $resource = 'users';

	public function __construct(
		AppRepositoryInterface $appRepo, 
		ModuleRepositoryInterface $moduleRepo, 
		UserRepositoryInterface $userRepo,
		RoleRepositoryInterface $roleRepo,
		PageRepositoryInterface $pageRepo)
	{
		parent::__construct($appRepo, $moduleRepo, $userRepo, $pageRepo);
		$this->roleRepo = $roleRepo;
	}

	public function getIndex()
	{
		if(!$this->currentUser->hasAdminRights())
		{
			 return 'this user can only manage modules<a href="http://spinn.dev/logout">logout</a>';
			 die();
		}
		
		$query = Input::all() ? Input::all() : null;

		$type = isset($query['type']) ? $query['type'] : null;

		$users = $this->userRepo->findByTypeAndParent($query, $this->currentUser->_id);

		$this->layout->content = View::make('users.index')
										->with('type', $type)
										->with('users', $users);


		return $this->layout;
	}

	public function getCreate()
	{

		$merchants = $this->userRepo->getMerchantIdsForDropdown();

		//$roles = $this->roleRepo->getDefaultRolesDropdownFormat();
		$roles = $this->roleRepo->getRolesDropdownFormat($this->currentUser->id);
		$types = $this->ac->getTypesDropdownForm();

		$dropdownFirstValue = array('0' => 'Please select...');

		$this->layout->content = View::make('users.create')
										->with('currentUser', $this->currentUser)
										->with('merchants', array_merge($dropdownFirstValue, $merchants))
										->with('roles', $roles)
										->with('types', array_merge($dropdownFirstValue, $types));

		return $this->layout;
	}

	public function postCreate()
	{

		if ( $this->userRepo->validate( Input::all() ) )
		{

			$this->userRepo->create(Input::all());

			Session::flash('message', 'User has been created successfully!');
			return Redirect::route( 'get.users.list');
		}

		return Redirect::back()->withInput()->withErrors( $this->userRepo->validatorInstance() );
	}

	public function getEdit( $id )
	{
		$user = $this->userRepo->findById( $id );

		$merchants = $this->userRepo->getMerchantIdsForDropdown();

		$types = $this->ac->getTypesDropdownForm();

		//only display roles for the selected merchant
		if($user->merchant_id)
		{
			$roles = $this->roleRepo->getRolesDropdownFormat($user->merchant_id);
		}
		else
		{
			$roles = $this->roleRepo->getRolesDropdownFormat($this->currentUser->id);
		}

		$dropdownFirstValue = array('' => 'Please select...');

		$this->layout->content = View::make('users.edit')
										->with('currentUser', $this->currentUser)
										->with('merchants', array_merge($dropdownFirstValue, $merchants))
										->with('user', $user)
										->with('roles', $roles)
										->with('types', array_merge($dropdownFirstValue, $types));

		return $this->layout;
	}

	public function postEdit( $id )
	{

		if ( $this->userRepo->validate(Input::all(), $id))
		{

			$this->userRepo->update( Input::all(), $id );

			Session::flash('message', 'User has been updated successfully!');
			return Redirect::route( 'get.users.list');
		}

		return Redirect::back()->withErrors( $this->userRepo->validatorInstance() );
	}

	public function getDelete( $id )
	{
		$user = $this->userRepo->findById( $id );

		if ($user) 
		{
			$user->delete();
		}

		Session::flash('message', 'User has been deleted successfully!');
		return Redirect::back();
	}

	public function getActivate($userId)
	{
		$userId = $userId ? $userId : null;
		$code = Input::get('code') ? Input::get('code') : null;

		if(is_null($userId) && is_null($code))
		{
			return 'Oops! this is a bad request!';
		}

		$user = $this->userRepo->findById($userId);

		if($user->activate($code))
		{
			return 'User has been activated!';
		}

		return 'User could not be activated!';
	}
}
