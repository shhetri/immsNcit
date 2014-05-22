<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeachersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teachers', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('teacher_info_id')->unsigned()->index();
			$table->integer('associated_subject')->unsigned()->index();
			$table->integer('year');
			$table->integer('semester')->unsigned()->index();
            $table->foreign('teacher_info_id')->references('id')->on('teacher_info');
            $table->foreign('associated_subject')->references('id')->on('subjects');
            $table->foreign('semester')->references('id')->on('secondary');
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
		Schema::drop('teachers');
	}

}
