<?php

use Illuminate\Database\Migrations\Migration;

class CreateDownloadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fbf_downloads', function($table)
		{
			$table->increments('id');
			$table->string('internal_ref');
			$table->string('title');
			$table->string('filename');
			$table->string('extension');
			$table->string('filesize');
			$table->string('image');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fbf_downloads');
	}

}