<?php namespace App\Modules\About\Repositories;

interface AboutRepositoryInterface {
	public function fieldsAndValue($linkKey);
	public function saveFields($linkKey, $inputs);
	public function saveFieldsMongo($linkKey, $inputs);
}