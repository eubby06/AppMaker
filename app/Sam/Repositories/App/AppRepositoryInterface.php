<?php namespace Sam\Repositories\App;

interface AppRepositoryInterface {
	
	public function findAll();
	public function findById($id);
	public function create($input);
	public function update($input, $id);
	public function validate($input);
	public function validatorInstance();
	public function getRelevantApps($user);
	public function getRelevantAppsDropdownFormat($user);
}