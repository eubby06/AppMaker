<?php namespace Sam\Helpers;

use Illuminate\Support\Facades\Facade;

class ResourceCounterFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'ResourceCounter'; }

}