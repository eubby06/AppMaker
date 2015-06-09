<?php namespace App\Modules\Contact\Models;

use CoreField;

class ModuleContact extends CoreField {

	protected $fields = array(
			'name',
			'title',
			'subtitle',
			'description',
			'email',
			'address',
			'website',
			'phone'
		);
	
	public $defaults = array(
			array('name' => 'name', 'type' => 'input', 'value' => ''),
			array('name' => 'title', 'type' => 'input', 'value' => ''),
			array('name' => 'subtitle', 'type' => 'input', 'value' => ''),
			array('name' => 'description', 'type' => 'textarea', 'value' => ''),
			array('name' => 'email', 'type' => 'input', 'value' => ''),
			array('name' => 'address', 'type' => 'textarea', 'value' => ''),
			array('name' => 'website', 'type' => 'input', 'value' => ''),
			array('name' => 'phone', 'type' => 'input', 'value' => ''),
		);

	public $timestamps = false;

	public function validField($key)
	{
		return in_array($key, $this->fields) ? true : false;
	}
}