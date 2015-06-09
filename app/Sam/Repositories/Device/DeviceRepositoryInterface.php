<?php namespace Sam\Repositories\Device;

interface DeviceRepositoryInterface {
	
	public function findAll();
	public function findById( $id );
	public function findByAppId($appId);
	public function findByUserIds($userIds);
	public function findByRoleIds($roleIds);
	public function findByCountries($countries);
	public function findByLocation($latitude,$longitude,$radius);
	public function getCountryByCoordinates($latitude,$longitude);
	public function validate( $input );
	public function create( $input );
	public function messages();
	
}