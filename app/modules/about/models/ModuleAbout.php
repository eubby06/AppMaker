<?php namespace App\Modules\About\Models;

use CoreField;

class ModuleAbout extends CoreField {

	protected $fields = array(
			'name',
			'title',
			'about',
			'description',
			'founded'
		);
	
	public $defaults = array(
			array('name' => 'name', 'type' => 'input', 'value' => ''),
			array('name' => 'title', 'type' => 'input', 'value' => ''),
			array('name' => 'about', 'type' => 'textarea', 'value' => ''),
			array('name' => 'description', 'type' => 'textarea', 'value' => ''),
			array('name' => 'founded', 'type' => 'input', 'value' => '')
		);

	public $timestamps = false;

	public function validField($key)
	{
		return in_array($key, $this->fields) ? true : false;
	}
}