<?php namespace App\Modules\ServicePackage\Models;

use CoreField;

class ServicePackageFacebook extends CoreField {

	public $timestamps = false;

	public function validField($key)
	{
		return in_array($key, $this->fields) ? true : false;
	}
}