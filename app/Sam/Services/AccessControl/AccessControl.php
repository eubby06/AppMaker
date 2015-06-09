<?php namespace Sam\Services\AccessControl;

use Sam\Repositories\User\UserRepositoryInterface,
	Sam\Repositories\Role\RoleRepositoryInterface,
	Hash,
	Redirect,
	Cookie,
	Config,
	Session;

class AccessControl
{
	public $user;
	public $userRepo;
	public $roleRepo;

	public function __construct(UserRepositoryInterface $userRepo, RoleRepositoryInterface $roleRepo)
	{
		$this->userRepo = $userRepo;
		$this->roleRepo = $roleRepo;
		$this->user = null;
	}

	public function check()
	{

		if (is_null($this->user))
		{
			// Check session first, follow by cookie
			if ( ! $userArray = Session::get('SamPersistentData') and ! $userArray = Cookie::get('SamPersistentData'))
			{
				return false;
			}

			// Now check our user is an array with two elements,
			// the username followed by the persist code
			if ( ! is_array($userArray) or count($userArray) !== 2)
			{
				return false;
			}

			list($id, $persistCode) = $userArray;


			// Let's find our user
			try
			{
				$user = $this->userRepo->findById($id);
			}
			catch (UserNotFoundException $e)
			{
				return false;
			}

			// Great! Let's check the session's persist code
			// against the user. If it fails, somebody has tampered
			// with the cookie / session data and we're not allowing
			// a login

			if ( ! $user->checkPersistCode($persistCode))
			{
				return false;
			}

			// Now we'll set the user property on Sentry
			$this->user = $user;
		}

		
		// Let's check our cached user is indeed activated
		if ( ! $user = $this->getUser() or ! $user->isActivated() or $user->isBanned())
		{
			return false;
		}

		return true;
	}

	public function logout()
	{
		$this->user = null;

		Session::forget('SamPersistentData');
		$cookie = Cookie::forget('SamPersistentData');

		return Redirect::to('login')->withCookie($cookie);
	}

	public function login( $input = array(), $redirect )
	{
		//find user with this email
		$user = $this->userRepo->findByEmail( $input['email'] );

		return $this->authenticate( $input, $user ) ? $this->_login( $input, $user, $redirect ) : Redirect::back()->with('message', 'e-mail or password is invalid!');
	}

	public function authenticate( $input, $user )
	{
		// check users status first
		if (!$user || !$user->isActivated() || $user->isBanned())
		{
			return false;
		}

		//check if user has a correct password
		if(!Hash::check($input['password'], $user->password))
		{
			return false;
		}

		//check if user has access rights to the admin
		if(!$user->hasManageableRights())
		{
			return false;
		}

		return true;
	}

	protected function _login( $input, $user, $redirect )
	{
		$persistentData = array($user->_id, $user->getPersistCode());
		$rememberMe = isset($input['remember_me']) ? true : false;

		return $this->_persistUser( $persistentData, $rememberMe, $redirect );
	}

	protected function _persistUser( $persistentData, $rememberMe = false, $redirect )
	{
		if( !$rememberMe )
		{
			Session::put( 'SamPersistentData', $persistentData );
			return Redirect::to( $redirect );
		}
		else
		{
			$cookie = Cookie::forever( 'SamPersistentData', $persistentData );
			return Redirect::to( $redirect )->withCookie( $cookie );
		}
	}

	public function getUser()
	{
		// We will lazily attempt to load our user
		if (is_null($this->user))
		{
			$this->check();
		}

		return $this->user;
	}

	public function getRolesDropdownForm()
	{
		$user = $this->getUser();

		$roles = Config::get('user.roles');

		foreach($roles as $key => $value)
		{
			$permission = 'can.create.' . $key;

			if(!$user->hasAdminPermission($permission))
			{
				unset($roles[$key]);
			}
		}
		
		return $roles;
	}

	public function getTypesDropdownForm()
	{
		$user = $this->getUser();

		$types = Config::get('user.types');

		foreach($types as $key => $value)
		{
			$permission = 'can.create.' . $key;

			if(!$user->hasAdminPermission($permission))
			{
				unset($types[$key]);
			}
		}
		
		return $types;
	}

}
