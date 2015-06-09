<?php

use Sam\Repositories\User\UserRepositoryInterface;

class LoginController extends Controller {

	protected $layout = 'layouts.login';

	public $userRepo;

	public $ac;

	public function __construct(UserRepositoryInterface $userRepo)
	{
		$this->ac = App::make('AccessControl');
		$this->userRepo = $userRepo;
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function getIndex()
	{
		if( $this->ac->check() )
		{
			return Redirect::to('en/users');
		}

		$this->layout->content = View::make('login.index');

		return $this->layout;
	}

	public function postIndex()
	{
		$credentials = Input::all();
		$redirect = 'en/dashboard';

		if( !$credentials['email'] || !$credentials['password'])
		{
			Session::flash('message', 'e-mail or password is invalid!');
			return Redirect::back();
		}

		return $this->ac->login( $credentials, $redirect );
	}

	public function getLogout()
	{
		return $this->ac->logout();
	}

	public function getRequest($something)
	{
		$this->layout->content = View::make('login.request');

		return $this->layout;
	}

	public function postRequest($something)
	{
		if($something != 'password')
		{
			return Redirect::back();
		}

		if(!Input::get('email'))
		{
			Session::flash('message', 'Please enter your email address!');
			return Redirect::back();
		}

		if(!$user = $this->userRepo->findByEmail(Input::get('email')))
		{
			Session::flash('message', 'There is no user with email: <b>' . Input::get('email') . '</b>');
			return Redirect::back();
		}

		$this->userRepo->sendResetPasswordNotification($user);

		Session::flash('success', 'We have sent you the instruction on how to reset your password!');
		return Redirect::to('login');
	}

	public function getReset($userId)
	{
		$userId = $userId ? $userId : null;
		$code = Input::get('code') ? Input::get('code') : null;

		if(is_null($userId) || is_null($code))
		{
			App::abort(404, 'User not found');
		}

		$user = $this->userRepo->findById($userId);

		if(!$user)
		{
			App::abort(404, 'User not found');
		}

		$this->layout->content = View::make('login.reset')
										->with('user', $user)
										->with('code', $code);

		return $this->layout;
	}

	public function postReset()
	{
		$user = $this->userRepo->findById(Input::get('user'));
		$code = Input::get('code');

		//reset codes should match
		if(!$user || ($user->reset_code != $code))
		{
			Session::flash('message', 'Sorry but this request could not be processed!');
			return Redirect::back();
		}

		//passwords should match
		if(Input::get('password') != Input::get('password_confirmation'))
		{
			Session::flash('message', 'Passwords do not match!');
			return Redirect::back();
		}

		//check for minimum number of characters
		if(strlen(Input::get('password')) < 8 )
		{
			Session::flash('message', 'Password should be at least 8 characters!');
			return Redirect::back();
		}

		//if all is ok, then set the new password
		$user->password = Input::get('password');
		$user->save();

		Session::flash('success', 'Password has been reset, please login!');
		return Redirect::to('login');
	}
}