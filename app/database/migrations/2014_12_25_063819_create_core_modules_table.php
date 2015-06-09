<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_modules', function($table)
		{
			$table->increments('id');
			$table->string('key');
			$table->string('name');
			$table->text('description');
			$table->integer('no_of_installation')->unsigned();
			$table->integer('version_number')->unsigned();
			$table->timestamps();
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
		Schema::drop('core_modules');
	}

}
