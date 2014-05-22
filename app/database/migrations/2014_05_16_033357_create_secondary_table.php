<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSecondaryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('secondary', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('master_id')->unsigned()->index();
			$table->string('secondary_data', 100);
            $table->foreign('master_id')->references('id')->on('master');
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
		Schema::drop('secondary');
	}

}
