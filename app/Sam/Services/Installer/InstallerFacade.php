<?php namespace Sam\Services\Installer;

use Illuminate\Support\Facades\Facade;

class InstallerFacade extends Facade {

    protected static function getFacadeAccessor() { return 'installer'; }

}