<?php

/**
 * @file DatabaseSeeder.php
 * @brief Runs all the other seeder
 * @author Sumit Chhetri
 * @date 6/7/14
 * @bug No known bugs
 */
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('SemesterTableSeeder');
	}

}
