<?php namespace Sam\Repositories\Module;

interface ModuleRepositoryInterface {
	
	public function findAll();
	public function findById($id);
	public function create($input);
	public function update($input, $id);
	public function validate($input);
	public function validatorInstance();
	public function getModuleIdsForDropdown();
	public function getMerchantPrivateModules($user);
	public function getManageables();
}