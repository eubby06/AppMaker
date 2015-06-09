<?php

use Sam\Repositories\App\AppRepositoryInterface;
use Sam\Repositories\Module\ModuleRepositoryInterface;
use Sam\Repositories\User\UserRepositoryInterface;
use Sam\Repositories\Role\RoleRepositoryInterface;
use Sam\Repositories\Device\DeviceRepositoryInterface;

class NotificationApiController extends Controller {

	public $roleRepo;
	public $appRepo;
	public $moduleRepo;
	public $userRepo;
	public $deviceRepo;

	public function __construct(
		RoleRepositoryInterface $roleRepo,
		AppRepositoryInterface $appRepo, 
		ModuleRepositoryInterface $moduleRepo, 
		DeviceRepositoryInterface $deviceRepo,
		UserRepositoryInterface $userRepo)
	{
		$this->roleRepo = $roleRepo;
		$this->appRepo = $appRepo;
		$this->moduleRepo = $moduleRepo;
		$this->userRepo = $userRepo;
		$this->deviceRepo = $deviceRepo;
	}

	public function postIndex()
	{
		$data = Input::all() ? Input::all() : null;
		$devices = array();

		$app = Input::get('appId') ? $this->appRepo->findById(Input::get('appId')) : null;

		// make sure valid inputs are available
		if(is_null($app) || is_null($data))
		{
			return false;
		}

		//target users of this notification
		$target = Input::get('target');

		switch($target)
		{
			// all installed apps on devices
			case 'device':
				$devices = $this->deviceRepo->findByAppId($data['appId']);
			break;

			// only users with this particular role
			case 'group':
				$devices = $this->deviceRepo->findByRoleIds($data['roles']);
			break;

			// only users from this country
			case 'country':
				$devices = $this->deviceRepo->findByCountries($data['countries']);
			break;

			// get devices within the given latitude, longitude and radius
			case 'location':
				$devices = $this->deviceRepo->findByLocation($data['latitude'], $data['longitude'], $data['radius']);
			break;
		}

		// push to queue
		//$this->startQueueMessage($devices, $data);

		return Response::json(['success' => true], 200);
	}

	public function generateDeviceCollection($devices)
	{
		$data = array();

		foreach($devices as $device)
		{
			$data[] = PushNotification::Device($device->token, array('badge' => 1));
		}

		return $data;
	}

	public function startQueueMessage($devices, $data)
	{
		$deviceCollection = $this->generateDeviceCollection($devices);

		$devices = PushNotification::DeviceCollection($deviceCollection);

		$message = PushNotification::Message($data['message'], array('badge' => 1));

		Queue::push(function($job) use ($devices, $data)
		{
			//PushNotification::app('appNameIOS')
					  //  ->to($devices)
					  //  ->send($message);
			$message = '';

			foreach($devices as $device)
			{
				$message .= 'sending message('. $data['message'] .') to ' . $device->token . ' : ';
			}

			File::append(app_path().'/queue.txt', $message.PHP_EOL);

		    $job->delete();
		});
	}
}