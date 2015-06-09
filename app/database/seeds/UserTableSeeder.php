<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('core_users')->delete();

        CoreUser::setHasher(new Cartalyst\Sentry\Hashing\NativeHasher);
        CoreUser::create(
        	array(
        		'email' 		=> 'foo@bar.com',
        		'password' 		=> Hash::make('secret'),
        		'first_name' 	=> 'Daniel',
        		'last_name' 	=> 'Wu'
        		)
        	);
    }

}