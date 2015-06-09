<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreAppsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_apps', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('package_name');
			$table->string('type')->nullable();
			$table->string('facebook')->nullable();
			$table->integer('no_of_installation')->unsigned();
			$table->integer('owner_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->boolean('activated')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_apps');
	}

}
