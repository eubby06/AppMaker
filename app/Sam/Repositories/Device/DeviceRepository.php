<?php namespace Sam\Repositories\Device;

use Sam\Repositories\Device\DeviceRepositoryInterface,
	CoreUser,
	CoreRole,
	CoreDevice;

class DeviceRepository implements DeviceRepositoryInterface{

	private $deviceModel;
	private $userModel;
	private $roleModel;

	public function __construct(CoreDevice $deviceModel, CoreUser $userModel, CoreRole $roleModel)
	{
		$this->deviceModel = $deviceModel;
		$this->userModel = $userModel;
		$this->roleModel = $roleModel;
	}

	public function findAll()
	{
		return $this->deviceModel->all();
	}

	public function findById($id)
	{
		return $this->deviceModel->find( $id );
	}

	public function findByAppId($appId)
	{
		$devices = $this->deviceModel->where('app_id','=',$appId)->get();

		return $devices;
	}

	public function findByUserIds($userIds)
	{
		$devices = $this->deviceModel->whereIn('user_id', $userIds)->get();

		return $devices;
	}

	public function findByRoleIds($roleIds)
	{
		$userIds = array();

		$users = $this->userModel->whereIn('role_ids', $roleIds)->get();

		foreach($users as $user)
		{
			$userIds[] = $user->id;
		}

		$devices = $this->findByUserIds($userIds);

		return $devices;
	}

	public function findByCountries($countries)
	{

		$userIds = array();
		$devices = array();

		$users = $this->userModel->whereIn('country', $countries)->get();

		if(count($users))
		{
			foreach($users as $user)
			{
				$userIds[] = $user->id;
			}

			// devices based on user's country
			$rawDevices = $this->findByUserIds($userIds);

			foreach($rawDevices as $device)
			{
				$devices[$device->id] = $device;
			}
		}

		// get devices by countries, because not all users are registered
		$unregisteredUsers = $this->deviceModel->whereIn('country', $countries)->get();

		if(count($unregisteredUsers))
		{
			foreach($unregisteredUsers as $device)
			{
				$devices[$device->id] = $device;
			}
		}

		return array_values($devices);
	}

	public function getCountryByCoordinates($latitude,$longitude)
	{
		$countryCode = "http://ws.geonames.org/countryCode?lat=" . $latitude . "&lng=" . $longitude . "&username=eubby06";

		return $countryCode;
	}

	public function findByLocation($latitude,$longitude,$radius)
	{
		$devices = $this->findAll();

		$devicesWithinRadius = array();

		foreach($devices as $device)
		{
			if($this->isWithinRadius($device->latitude,$device->longitude,$latitude,$longitude,$radius))
			{
				$devicesWithinRadius[] = $device;
			}
		}

		return $devicesWithinRadius;
	}

	public function isWithinRadius($latitude1, $longitude1, $latitude2, $longitude2, $radius)
	{
		$distance = $this->getDistance($latitude1, $longitude1, $latitude2, $longitude2);

		return ($distance < ($radius * 0.001)) ? true : false;
	}

	function getDistance( $latitude1, $longitude1, $latitude2, $longitude2 )
	{  
	    $earth_radius = 6371;

	    $dLat = deg2rad( $latitude2 - $latitude1 );  
	    $dLon = deg2rad( $longitude2 - $longitude1 );  

	    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
	    $c = 2 * asin(sqrt($a));  
	    $d = $earth_radius * $c;  

	    return $d;  
	}

	public function validate( $input )
	{
		return $this->deviceModel->validate( $input );
	}

	public function create( $input )
	{
		return $this->deviceModel->create( $input );
	}

	public function messages()
	{
		return $this->deviceModel->messages();
	}
}