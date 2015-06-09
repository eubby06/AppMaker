<?php namespace Sam\Repositories\Page;

interface PageRepositoryInterface {
	
	public function findAll();
	public function findById($id);
	public function create($input);
	public function update($input, $id);
	public function validate($input);
	public function validatorInstance();
}