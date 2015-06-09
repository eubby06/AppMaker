<?php namespace Sam\Repositories\App;

use Sam\Repositories\App\AppRepositoryInterface,
 	Sam\Repositories\User\UserRepositoryInterface,
	CoreApp;

class AppRepository implements AppRepositoryInterface{

	private $appModel;
	private $userRepo;

	public function __construct(CoreApp $appModel, UserRepositoryInterface $userRepo)
	{
		$this->appModel = $appModel;
		$this->userRepo = $userRepo;
	}

	public function findAll()
	{
		return $this->appModel->all();
	}

	public function findById($id)
	{
		return $this->appModel->find($id);
	}

	public function create($input)
	{
		return $this->appModel->create($input);
	}

	public function update($input, $id)
	{
		$app = $this->appModel->find($id);
		$app->fill($input);
		$app->save();
	}

	public function validate($input)
	{
		return $this->appModel->validate($input);
	}

	public function validatorInstance()
	{
		return $this->appModel->validatorInstance();
	}

	public function getRelevantAppsDropdownFormat($user)
	{
		$apps = $this->getRelevantApps($user);

		$dropdown = array();

		foreach($apps as $app)
		{
			$dropdown[$app->_id] = $app->name;
		}

		return $dropdown;
	}

	public function getRelevantApps($user)
	{
		$apps = '';

		if($user->isSuper())
		{
			$apps = $this->findAll();
		}

		if($user->isAdmin())
		{

			//get merchants
			$merchantIds = $this->userRepo->getMerchantIdsOnly($user->_id);

			//get apps
			$apps = $this->appModel->channelApps($merchantIds);
		}

		if($user->isManager())
		{
			//get apps
			$apps = $this->appModel->merchantApps($user->_id);
		}

		return $apps;
	}
}