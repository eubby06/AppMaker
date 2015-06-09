<?php

class AppModuleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('core_apps_modules')->delete();

        DB::table('core_apps_modules')->insert(
        	array(
        		'app_id'		=> 1,
        		'module_id'    => 1
        		)
        	);

        DB::table('core_apps_modules')->insert(
            array(
                'app_id'       => 1,
                'module_id'    => 2
                )
        );

        DB::table('core_apps_modules')->insert(
            array(
                'app_id'       => 1,
                'module_id'    => 3
                )
        );
    }

}