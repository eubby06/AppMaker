<?php namespace Sam\Repositories\Permission;

use Sam\Repositories\Permission\PermissionRepositoryInterface,
	CorePermission;

class PermissionRepository implements PermissionRepositoryInterface{

	private $permissionModel;

	public function __construct(CorePermission $permissionModel)
	{
		$this->permissionModel = $permissionModel;
	}

	public function findAll()
	{
		return $this->permissionModel->all();
	}

	public function findById($id)
	{
		return $this->permissionModel->find( $id );
	}

	public function findByType( $type )
	{
		return $this->permissionModel->where('type', '=', $type)->get();
	}

	public function validate( $input )
	{
		return $this->permissionModel->validate( $input );
	}

	public function create( $input )
	{
		return $this->permissionModel->create( $input );
	}

	public function messages()
	{
		return $this->permissionModel->messages();
	}
}