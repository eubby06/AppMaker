<?php 

use Jenssegers\Mongodb\Model as Eloquent;

class CorePage extends Eloquent {

	protected $collection = 'pages';

    public $validator;

    protected $fillable = array(
    	'_id', 
    	'module_id',
    	'app_id',
    	'name'
    	);

    public function module()
    {
    	return $this->hasOne('CoreModule', 'module_id');
    }

    public function app()
    {
    	return $this->belongsTo('CoreApp', 'app_id');
    }

}