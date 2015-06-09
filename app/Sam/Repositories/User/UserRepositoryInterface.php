<?php namespace Sam\Repositories\User;

interface UserRepositoryInterface {
	
	public function findAll();
	public function findById($id);
	public function findByEmail($email);
	public function findByType($type);
	public function findByTypeAndParent($query,$parent);
	public function findByParent($id);
	public function validate($input);
	public function create($input);
	public function saveToRole($user);
	public function sendActivationEmail($user);
	public function update($input, $id);
	public function validatorInstance();
	public function getMerchants($id);
	public function getMerchantIdsOnly($id);
	public function getMerchantIdsForDropdown($id);
	public function getAppsAndManageableModules($userId);
}