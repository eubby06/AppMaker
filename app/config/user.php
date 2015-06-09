<?php

return array(

		'roles' => array(
					'super' 	=> 'Super Administrator',
					'admin' 	=> 'Administrator',
					'manager' 	=> 'Manager'
					),
		'types' => array(
					'system' 	=> 'System',
					'channel' 	=> 'Channel',
					'merchant' 	=> 'Merchant',
					'user' 		=> 'User'
					),
		'permissions' => array(
					'550143b8bffebc0b128b4567'	=> array( //super admin
								'user_management' => array(
														'can.create.super',
														'can.create.admin',
														'can.create.manager',
														'can.create.user',
														'can.create.system',
														'can.create.channel',
														'can.create.merchant',
														'can.view.user',
														'can.delete.user',
														'can.edit.user'
														),
								'module_management' => array(
														'can.create.module',
														'can.view.module',
														'can.delete.module',
														'can.edit.module'
														),
								'app_management' => array(
														'can.create.app',
														'can.view.app',
														'can.delete.app',
														'can.edit.app',
														'can.add.module',
														'can.view.module',
														'can.delete.module',
														'can.edit.module',
														'can.manage.module'
														)
						),
					'550143c9bffebc10128b4567' => array( //administrator
								'user_management' => array(
														'can.create.manager',
														'can.create.user',
														'can.create.merchant',
														'can.view.user',
														'can.delete.user',
														'can.edit.user'
														),
								'app_management' => array(
														'can.create.app',
														'can.view.app',
														'can.delete.app',
														'can.edit.app',
														'can.add.module',
														'can.view.module',
														'can.delete.module',
														'can.edit.module',
														'can.manage.module'
														)
						),
					'550143dbbffebc13128b4567' => array( //manager
								'user_management' => array(
														'can.create.user',
														'can.view.user',
														'can.delete.user',
														'can.edit.user',
														'can.manage.module'
														)
						)
			)

	);