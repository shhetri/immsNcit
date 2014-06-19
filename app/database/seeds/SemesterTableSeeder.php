<?php
/**
 * @file SemesterTableSeeder.php
 * @brief Add the default data in 'semesters' table
 * @author SHhetri
 * @date 5/24/14
 * @bug No known bugs
 */


class SemesterTableSeeder extends Seeder{

    public function run()
    {
        Eloquent::unguard();

        DB::table('semesters')->delete();

        Semester::create([
                'semester_name'  => 'First',
                'semester_no'   =>  1
            ]);
        Semester::create([
                'semester_name'  => 'Second',
                'semester_no'   =>  2
            ]);
        Semester::create([
                'semester_name'  => 'Third',
                'semester_no'   =>  3
            ]);
        Semester::create([
                'semester_name'  => 'Fourth',
                'semester_no'   =>  4
            ]);
        Semester::create([
                'semester_name'  => 'Fifth',
                'semester_no'   =>  5
            ]);
        Semester::create([
                'semester_name'  => 'Sixth',
                'semester_no'   =>  6
            ]);
        Semester::create([
                'semester_name'  => 'Seventh',
                'semester_no'   =>  7
            ]);
        Semester::create([
                'semester_name'  => 'Eighth',
                'semester_no'   =>  8
            ]);
    }

}