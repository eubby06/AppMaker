<?php 

use Jenssegers\Mongodb\Model as Eloquent;

class CoreApp extends Eloquent {

	protected $collection = 'apps';

    public $validator;

    protected $fillable = array(
    	'_id', 
    	'name', 
    	'merchant_id',
    	'module_ids',
    	'page_ids',
    	'protected'
    	);

	public static $rules = array(
    	'name' 	 	=> 'required|max:60',
    	'merchant_id' => 'required'
	);

	public function pages()
	{
		return CorePage::whereIn('_id', $this->page_ids);
	}

	public function getPagesAttribute()
	{
		return $this->pages()->get();
	}

	public function devices()
	{
		return $this->hasMany('CoreDevice','app_id');
	}

	public function merchantApps($merchantId)
	{
		return $this->where('merchant_id', $merchantId)->get();
	}

	public function channelApps($merchantIds)
	{
		return $this->whereIn('merchant_id', $merchantIds)->get();
	}

    public function modules()
    {
        return CoreModule::whereIn('_id', $this->module_ids);
    }

    public function getModulesAttribute()
    {
       return $this->modules()->get();
    }

	public function privateModules()
	{
		$module_ids = array();

		$pages = CorePage::select('module_id')->whereIn('_id', $this->page_ids)->get();

		foreach($pages as $page)
		{
			$module_ids[] = $page->module_id;
		}

		return CoreModule::where('protected','1')->whereIn('_id', $module_ids)->get();
	}

	public function manageableModules()
	{
		$module_ids = array();

		$pages = CorePage::select('module_id')->whereIn('_id', $this->page_ids)->get();

		foreach($pages as $page)
		{
			$module_ids[] = $page->module_id;
		}

		return CoreModule::where('manageable','=','1')->whereIn('_id', $module_ids)->get();
	}

	public function merchant()
	{
		return $this->belongsTo('CoreUser','merchant_id');
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