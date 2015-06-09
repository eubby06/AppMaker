<?php namespace App\Modules\Contact\Repositories;

use App\Modules\Contact\Repositories\ContactRepositoryInterface;
use App\Modules\Contact\Models\ModuleContact;

class ContactRepository implements ContactRepositoryInterface{

	private $contactModel;

	public function __construct(ModuleContact $contactModel)
	{
		$this->contactModel = $contactModel;
	}

	public function getType($key)
	{
		$defaults = $this->contactModel->defaults;

		$item = array_filter($defaults, function($item) use($key)
		{
			return ($item['name'] == $key) ? true : false;
		});

		$item = array_shift($item);
		return $item['type'];
	}

	public function saveFields($linkKey, $inputs)
	{
		if($inputs)
		{
			unset($inputs['_token']);

			foreach($inputs as $key => $value)
			{

				$inputType = $this->getType($key);

				if( $this->contactModel->validField($key) )
				{
					$field = $this->contactModel
								->where('name', '=', $key)
								->where('link_key','=',$linkKey)
								->first();	
					if($field)
					{
						$field->value = $value;
						$field->save();							
					}	
					else
					{
						$this->contactModel->insert(array(
							'name' => $key,
							'value' => $value,
							'type' => $inputType,
							'link_key' => $linkKey
							));
					}
				}
			}
		}
	}

	public function fieldsAndValue($linkKey)
	{
		$defaults = $this->contactModel->defaults;

		$fields = $this->contactModel
						->where('link_key','=',$linkKey)
						->get();

		$newDefaults = array_filter($defaults, function($item) use($fields){
						$match = false;

						foreach($fields->toArray() as $field)
						{
							$match = ($item['name'] == $field['name']) ? true : false;

							if($match)
								break;
						}

						return !$match;
					});

		return array_merge($fields->toArray(), $newDefaults);
	}
}