<?php

class ModuleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('core_modules')->delete();

        CoreModule::create(
        	array(
                'name'                  => 'about us',
                'key'                   => '7699aded6da716dbca47963fhee85c67',
                'description'           => 'a little info about your company',
                'no_of_installation'    => 3,
                'version_number'        => 2,
                'activated'             => 1
        		)
        	);

        CoreModule::create(
            array(
                'name'                  => 'contact us',
                'key'                   => '7699aded6da716dbca47963faee85c67',
                'description'           => 'a contact info of your company',
                'no_of_installation'    => 6,
                'version_number'        => 3,
                'activated'             => 1
                )
            );

        CoreModule::create(
            array(
                'name'                  => 'service package',
                'key'                   => '7699aded6da716dbca47963fnee85c67',
                'description'           => 'a service package management module',
                'no_of_installation'    => 7,
                'version_number'        => 4,
                'activated'             => 1
                )
            );
    }

}