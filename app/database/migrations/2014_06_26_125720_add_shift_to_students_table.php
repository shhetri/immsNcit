<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class AddShiftToStudentsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('students', function (Blueprint $table) {
                $table->integer('shift_id')->after('faculty_id');
            });
        }


        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('shift_id');
            });
        }

    }
