<?php namespace Sam\Repositories\Role;

interface RoleRepositoryInterface {
	
	public function findAll();
	public function findById( $id );
	public function findByAppId($id);
	public function getRoles($merchant_id, $query = null, $paginated = false);
	public function getRolesDropdownFormat($userId);
	public function validate( $input );
	public function create( $input );
	public function update( $input, $id );
	public function validatorInstance();
	
}