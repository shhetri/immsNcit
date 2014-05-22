<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMarksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('marks', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('student_id')->unsigned()->index();
			$table->integer('subject_id')->unsigned()->index();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('subject_id')->references('id')->on('subjects');
			$table->integer('attendance_marks');
			$table->integer('tutorial_marks');
			$table->integer('unit_test_marks');
			$table->integer('assessment_marks');
			$table->integer('practical_marks');
			$table->integer('viva_marks');
			$table->string('remarks', 45);
			$table->integer('year');
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
		Schema::drop('marks');
	}

}
