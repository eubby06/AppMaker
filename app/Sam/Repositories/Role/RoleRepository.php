<?php namespace Sam\Repositories\Role;

use Sam\Repositories\Role\RoleRepositoryInterface,
	CoreUser,
	CoreRole;

class RoleRepository implements RoleRepositoryInterface{

	private $roleModel;
	private $userModel;

	public function __construct(CoreRole $roleModel, CoreUser $userModel)
	{
		$this->roleModel = $roleModel;
		$this->userModel = $userModel;
	}

	public function findAll()
	{
		return $this->roleModel->all();
	}

	public function findById($id)
	{
		return $this->roleModel->find( $id );
	}

	public function findByAppId($id)
	{
		return $this->roleModel->where('app_id','=',$id)->get();
	}

	public function validate( $input )
	{
		return $this->roleModel->validate( $input );
	}

	public function create( $input )
	{
		return $this->roleModel->create( $input );
	}

	public function update( $input, $id )
	{
		$user = $this->roleModel->find( $id );
		$user->fill( $input );
		$user->save();
	}

	public function validatorInstance()
	{
		return $this->roleModel->validatorInstance();
	}

	public function getRoles($userId, $search = null, $paginate = false)
	{
		$roles = '';
		$merchantIds = null;
		$type = 'merchant';

		$user = $this->userModel->find($userId);

		if($user->isSuper())
		{
			$where 	= function($query) use($search){
						if(!is_null($search))
						{
							$query->where('name', 'LIKE', '%'.$search.'%');
						}
					};

			$roles = $paginate ? $this->roleModel->where($where)->paginate($paginate) : $this->roleModel->where($where)->get();
		}
		
		if($user->isManager())
		{
			$userId = $user->id;

			$where 	= function($query) use($search, $userId){

						if(!is_null($search))
						{
							$query->where('name', 'LIKE', '%'.$search.'%');
						}

						if(!is_null($userId))
						{
							$query->where('merchant_id', $userId);
						}
					};

			$roles = $paginate ? $this->roleModel->where($where)->orWhere('type','default')->paginate($paginate) : $this->roleModel->where($where)->orWhere('type','default')->get();
		}
		
		if($user->isAdmin())
		{
			$merchantIds = $user->merchants;

			$where 	= function($query) use($search, $merchantIds){
						if(!is_null($search))
						{
							$query->where('name', 'LIKE', '%'.$search.'%');
						}

						if(!is_null($merchantIds))
						{
							$query->whereIn('merchant_id', $merchantIds);
						}

						$roles = $paginate ? $this->roleModel->where($where)->orWhere('type','default')->paginate($paginate) : $this->roleModel->where($where)->orWhere('type','default')->get();
					};
		}

		return $roles;
	}

	public function getRolesDropdownFormat($userId)
	{
		$roles = $this->getRoles($userId, null, false);

		$dropdown = array();

		foreach($roles as $role)
		{
			$dropdown[$role->_id] = $role->name;
		}

		return $dropdown;
	}

}