<?php namespace App\Modules\Scorecard\Models;

use CoreField;

class ScorecardFacebook extends CoreField {

	public $timestamps = false;

	public function validField($key)
	{
		return in_array($key, $this->fields) ? true : false;
	}
}