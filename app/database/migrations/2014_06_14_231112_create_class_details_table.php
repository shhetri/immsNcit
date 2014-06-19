<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('class_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->integer('faculty_id')->unsigned()->index();
			$table->integer('semester_id')->unsigned()->index();
			$table->integer('shift_id')->unsigned()->index();
			$table->string('batch', 10);
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
		Schema::drop('class_details');
	}

}
