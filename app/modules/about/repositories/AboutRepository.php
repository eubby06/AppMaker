<?php namespace App\Modules\About\Repositories;

use App\Modules\About\Repositories\AboutRepositoryInterface,
 	App\Modules\About\Models\ModuleAbout,
	Exception,
	MongoModule,
	MongoApp;

class AboutRepository implements AboutRepositoryInterface{

	private $aboutModel;

	public function __construct(ModuleAbout $aboutModel)
	{
		$this->aboutModel = $aboutModel;
	}

	public function getType($key)
	{
		$defaults = $this->aboutModel->defaults;

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
			$dataForMongo = array();

			foreach($inputs as $key => $value)
			{

				$inputType = $this->getType($key);

				if( $this->aboutModel->validField($key) )
				{
					$dataForMongo[$key] = $value;

					$field = $this->aboutModel
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
						$this->aboutModel->insert(array(
							'name' => $key,
							'value' => $value,
							'type' => $inputType,
							'link_key' => $linkKey
							));
					}
				}
			}

			//update mongodb in meteor server
			$this->saveFieldsMongo($linkKey, $dataForMongo);
		}
	}

	public function saveFieldsMongo($linkKey, $dataForMongo)
	{
		try {

		 	$module = MongoModule::find($linkKey);

		} catch(Exception $e) {

		 	DB::reconnect('mongodb');
		 	$module = MongoModule::find($linkKey);
		}	

		//update mongo database
		$module->title = $dataForMongo['name'];
		$module->save();
	}

	public function fieldsAndValue($linkKey)
	{
		$defaults = $this->aboutModel->defaults;

		$fields = $this->aboutModel
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