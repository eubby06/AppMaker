<?php 

use Jenssegers\Mongodb\Model as Eloquent;

class CoreModule extends Eloquent {

	protected $collection = 'modules';

    public $validator;

    protected $fillable = array(
    	'_id', 
    	'name',
    	'protected',
    	'manageable'
    	);

	public static $rules = array(
    	'name' 	 	=> 'required|max:60'
	);

	public function scopeManageables($query)
	{
		return $query->where('manageable','=','1');
	}

	public function validate( $input )
	{

		$validator = Validator::make( $input, self::$rules );

		if( $validator->fails() )
		{
			$this->validator = $validator;

			return false;
		}

		return true;
	}

	public function validatorInstance()
	{
		return $this->validator;
	}
}