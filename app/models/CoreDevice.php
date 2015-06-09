<?php 

use Jenssegers\Mongodb\Model as Eloquent;

class CoreDevice extends Eloquent {

    protected $collection = 'devices';
    
    protected $fillable = array(
    	'_id', 
    	'app_id',
    	'user_id',
    	'token',
		'model',
		'cordova',
		'platform',
		'uuid',
		'version',
		'name',
		'latitude',
		'longitude',
		'country'
    	);
}