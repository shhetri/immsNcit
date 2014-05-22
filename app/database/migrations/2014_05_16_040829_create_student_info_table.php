<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student_info', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name', 100);
			$table->string('last_name', 100);
			$table->integer('roll_no');
			$table->integer('batch');
			$table->integer('faculty')->unsigned()->index();
			$table->integer('shift')->unsigned()->index();
            $table->foreign('faculty')->references('id')->on('secondary');
            $table->foreign('shift')->references('id')->on('secondary');
			$table->integer('status');
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
		Schema::drop('student_info');
	}

}
