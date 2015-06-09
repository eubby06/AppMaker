<?php namespace Sam\Services\AccessControl;

use Illuminate\Support\Facades\Facade;

class AccessControlFacade extends Facade {

    protected static function getFacadeAccessor() { return 'AccessControl'; }

}