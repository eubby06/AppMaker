<?php namespace App\Modules\Contact\Repositories;

interface ContactRepositoryInterface {
	public function fieldsAndValue($linkKey);
	public function saveFields($linkKey, $inputs);
}