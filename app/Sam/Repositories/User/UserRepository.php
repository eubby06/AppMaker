<?php namespace Sam\Repositories\User;

use Sam\Repositories\User\UserRepositoryInterface,
	CoreUser,
	CoreRole,
	Mail,
	DB;

class UserRepository implements UserRepositoryInterface{

	private $userModel;

	public function __construct(CoreUser $userModel)
	{
		$this->userModel = $userModel;
	}

	public function findAll()
	{
		return $this->userModel->all();
	}

	public function findById($id)
	{
		return $this->userModel->find( $id );
	}

	public function findByEmail( $email )
	{
		return $this->userModel->where('email', '=', $email)->first();
	}

	public function findByType($type)
	{
		return $this->userModel->where('type', '=', $type)->get();
	}

	public function findByParent($id)
	{
		return $this->userModel->where('type', '=', 'user')
											->where('merchant_id', '=', $id);
	}

	public function findByTypeAndParent($query,$parent_id)
	{
		$parent = $this->findById($parent_id);
		$parentRoles = $parent->roles;

		//pagination, no of records per page
		$numberOfItems = 10;

		//user objects to be returned
		$users = '';	

		//get params
		$search 	= isset($query['search']) ? $query['search'] : null;
		$type 		= isset($query['type']) ? $query['type'] : null;
		$field 		= isset($query['orderby']) ? $query['orderby'] : '_id';
		$sort 		= isset($query['sort']) ? $query['sort'] : 'asc';

		$where 		= function($query) use($search, $type){

						if(!is_null($type))
						{
							$query->where('type', $type);
						}

						if(!is_null($search))
						{
							$query->where('first_name', 'LIKE', '%'.$search.'%')
							->orWhere('last_name', 'LIKE', '%'.$search.'%')
							->orWhere('email', 'LIKE', '%'.$search.'%')
							->orWhere('company', 'LIKE', '%'.$search.'%');
						}

					};

		switch ($type) {
			case 'staff':

				if($parent->isSuper())
				{

					$users = $this->userModel->where($where)
											->orderBy($field, $sort)
											->paginate($numberOfItems);
				}

				break;
			case 'channel':

				if($parent->isSuper())
				{
					$users = $this->userModel->where($where)
											->orderBy($field, $sort)
											->paginate($numberOfItems);
				}

				break;
			case 'merchant':

				if($parent->isSuper())
				{
					$users = $this->userModel->where($where)
											->orderBy($field, $sort)
											->paginate($numberOfItems);
				}
				else
				{
					$users = $this->userModel->where($where)
											->where('channel_id', '=', $parent_id)
											->orderBy($field, $sort)
											->paginate($numberOfItems);
				}

				break;
			case 'user':
				//get merchants of this particular channel
				$merchants = $this->getMerchantIdsOnly($parent_id);

				if($parent->isSuper())
				{
					$users = $this->userModel->where($where)
											->orderBy($field, $sort)
											->paginate($numberOfItems);
										
				}
				else if($parent->isAdmin())
				{
					$users = $this->userModel->where($where)
											->whereIn('merchant_id', $merchants)
											->orderBy($field, $sort)
											->paginate($numberOfItems);
				}
				else
				{
					$users = $this->userModel->where($where)
											->where('merchant_id', $parent_id)
											->orderBy($field, $sort)
											->paginate($numberOfItems);		
				}

				break;
			default:

				//get merchants of this particular channel
				$merchants = $this->getMerchantIdsOnly($parent_id);

				if($parent->isSuper())
				{

					$users = $this->userModel->where($where)
											->orderBy($field, $sort)
											->paginate($numberOfItems);
				}
				else if($parent->isAdmin())
				{
					$users = $this->userModel->where($where)
											->whereIn('merchant_id', $merchants)
											->orWhere('channel_id', '=', $parent_id)
											->orderBy($field, $sort)
											->paginate($numberOfItems);
				}
				else
				{
					$users = $this->userModel->where($where)
											->where('merchant_id', $parent_id)
											->orderBy($field, $sort)
											->paginate($numberOfItems);		
				}

				break;
		}

		return $users;
	}

	public function validate($input, $id = null)
	{
		return $this->userModel->validate($input, $id);
	}

	public function create($input)
	{
		$user = $this->userModel->create($input);

		//this save user to role table
		$this->saveToRole($user);

		//send confirmation email if status is not set to activated
		if($input['status'] == 'unactivated')
		{
			$this->sendActivationEmail($user);
		}

		return $user;
	}

	public function saveToRole($user)
	{
		$user->roles->each(function($role) use($user)
	    {
	        $role->user_ids = is_array($role->user_ids) ? array_merge($role->user_ids, array($user->id)) : array($user->id);
	        $role->save();
	    });
	}

	public function sendActivationEmail($user)
	{
		$data = array(
					'fullname' => $user->fullname(),
					'url' => route('get.users.activate', array($user->id, 'code'=>$user->getActivationCode()))
					);

		Mail::send('emails.activation', $data, function($message) use($user)
		{
		    $message->to($user->email, $user->fullname())->subject('Activation Email');
		});
	}

	public function sendResetPasswordNotification($user)
	{
		$data = array(
					'fullname' => $user->fullname(),
					'url' => route('get.users.reset', array($user->id, 'code'=>$user->getResetCode()))
					);

		Mail::send('emails.reset', $data, function($message) use($user)
		{
		    $message->to($user->email, $user->fullname())->subject('Reset Password Notification');
		});
	}

	public function update($input, $id)
	{
		if(isset($input['new_password']))
		{
			$input['password'] = $input['new_password'];
		}

		$user = $this->userModel->find($id);
		$user->fill( $input );
		$user->save();

		//this save user to role table
		$this->saveToRole($user);
	}

	public function validatorInstance()
	{
		return $this->userModel->validatorInstance();
	}

	public function getMerchants($channelId = null)
	{
		$merchants = '';

		if(is_null($channelId))
		{
			$merchants = $this->userModel->where('type','=','merchant')
											->get();
		}
		else
		{
			$merchants = $this->userModel->where('type','=','merchant')
											->where('channel_id', '=', $channelId)
											->get();
		}
		

		return $merchants;
	}

	public function getMerchantIdsOnly($channelId = null)
	{

		$merchants = $this->getMerchants($channelId);

		$ids = array();

		foreach($merchants as $key => $value)
		{
			$ids[] = $value->_id;
		}

		return $ids;
	}

	public function getMerchantIdsForDropdown($channelId = null)
	{
		$merchants = $this->getMerchants($channelId);
	
		$ids = array();

		foreach($merchants as $key => $value)
		{
			$ids[$value->_id] = $value->first_name . ' ' . $value->last_name . ' - ' . $value->company;
		}

		return $ids;
	}

	public function getAppsAndManageableModules($user)
	{
		$data = array();

		$merchant = $user->merchant;

		$apps = $merchant->apps;

		foreach($apps as $app)
		{
			$data[$app->id]['app'] = $app;
			$data[$app->id]['modules'] = $app->modules;
		}

		return $data;
	}
}