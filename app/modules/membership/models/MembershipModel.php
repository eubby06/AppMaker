<?php namespace App\Modules\Membership\Models;

use CoreField;

class MembershipFacebook extends CoreField {

	public $timestamps = false;

	public function validField($key)
	{
		return in_array($key, $this->fields) ? true : false;
	}
}