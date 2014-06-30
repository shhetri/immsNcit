<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateStudentsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('students', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->integer('roll_no')->unique();
                $table->string('batch', 10);
                $table->integer('faculty_id')->unsigned()->index();
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
            Schema::drop('students');
        }

    }
