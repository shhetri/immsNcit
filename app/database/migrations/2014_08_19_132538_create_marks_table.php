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
			$table->float('unit_test')->default(0);
			$table->float('assessment')->default(0);
			$table->float('practical')->default(0);
			$table->float('attendance')->default(0);
			$table->float('tutorial')->default(0);
			$table->integer('teacher_id')->unsigned()->index();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->integer('student_id')->unsigned()->index();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->integer('subject_id')->unsigned()->index();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->integer('class_detail_id')->unsigned()->index();
            $table->foreign('class_detail_id')->references('id')->on('class_details')->onDelete('cascade');
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
