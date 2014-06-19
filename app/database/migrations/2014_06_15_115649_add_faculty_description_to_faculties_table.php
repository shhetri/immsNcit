<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class AddFacultyDescriptionToFacultiesTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('faculties', function (Blueprint $table) {
                $table->string('faculty_description')->after('faculty_name');
            });
        }


        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('faculties', function (Blueprint $table) {
                $table->dropColumn('faculty_description');
            });
        }

    }
