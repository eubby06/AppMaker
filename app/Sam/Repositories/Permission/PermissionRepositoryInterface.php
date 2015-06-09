<?php namespace Sam\Repositories\Permission;

interface PermissionRepositoryInterface {
	
	public function findAll();
	public function findById( $id );
	public function findByType( $type );
	public function validate( $input );
	public function create( $input );
	public function messages();
	
}