<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNoticeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notice', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('teacher_id')->unsigned()->index();
			$table->string('title', 250);
			$table->text('content');
			$table->enum('flag', [0,1,2]);
            $table->foreign('teacher_id')->references('id')->on('teachers');
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
		Schema::drop('notice');
	}

}
