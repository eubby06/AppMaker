<?php

class AppTableSeeder extends Seeder {

    public function run()
    {
        DB::table('core_apps')->delete();

        CoreApp::create(
        	array(
        		'name'					=> 'Spinn Labs',
        		'package_name'			=> '7699aded6da716dbca47963fdee85c67',
        		'no_of_installation'	=> 4,
        		'owner_id' 				=> 1,
        		'activated' 			=> 1
        		)
        	);
    }

}