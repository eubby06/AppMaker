<?php namespace Sam\Repositories\Module;

use Sam\Repositories\Module\ModuleRepositoryInterface,
	CoreModule;

class ModuleRepository implements ModuleRepositoryInterface{

	private $moduleModel;

	public function __construct(CoreModule $moduleModel)
	{
		$this->moduleModel = $moduleModel;
	}

	public function findAll()
	{
		return $this->moduleModel->all();
	}

	public function findById($id)
	{
		return $this->moduleModel->find($id);
	}

	public function create($input)
	{
		return $this->moduleModel->create($input);
	}

	public function update($input, $id)
	{
		$module = $this->moduleModel->find($id);
		$module->fill($input);
		$module->save();
	}

	public function validate( $input )
	{
		return $this->moduleModel->validate( $input );
	}

	public function validatorInstance()
	{
		return $this->moduleModel->validatorInstance();
	}

	public function getModuleIdsForDropdown()
	{
		$modules = $this->moduleModel->all();
		

		$ids = array();

		foreach($modules as $key => $value)
		{
			$ids[$value->_id] = $value->name;
		}

		return $ids;
	}

	public function getAppPrivateModules($app)
	{
		$modules = array();

		$modules[$app->_id]['app'] = $app;
		$modules[$app->_id]['modules'] = $app->privateModules();

		return $modules;
	}

	public function getAppManageableModules($app)
	{
		$modules = array();

		$modules[$app->_id]['app'] = $app;
		$modules[$app->_id]['modules'] = $app->manageableModules();

		return $modules;
	}

	public function getMerchantPrivateModules($user)
	{
		$modules = array();

		//get the merchant info of this particular user
		$merchant = $user->isManager() ? $user : $user->merchant;

		//get all apps of this merchant
		$merchantApps = $merchant->apps;

		//get modules of these apps
		foreach($merchantApps as $app)
		{
			$modules[$app->_id]['app'] = $app;
			$modules[$app->_id]['modules'] = $app->privateModules();
		}

		return $modules;
	}

	public function getMerchantManageablesModules($user)
	{
		$modules = array();

		//get the merchant info of this particular user
		$merchant = $user->isManager() ? $user : $user->merchant;

		//get all apps of this merchant
		$merchantApps = $merchant->apps;

		//get modules of these apps
		foreach($merchantApps as $app)
		{
			$modules[$app->_id]['app'] = $app;
			$modules[$app->_id]['modules'] = $app->manageableModules();
		}

		return $modules;
	}

	public function getManageables()
	{
		return $this->moduleModel->manageables()->get();
	}
}