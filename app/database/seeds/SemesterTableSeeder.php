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
        DB::table('semesters')->delete();

        Semester::create([
                'semester_name'  => 'first',
                'semester_no'   =>  1
            ]);
        Semester::create([
                'semester_name'  => 'second',
                'semester_no'   =>  2
            ]);
        Semester::create([
                'semester_name'  => 'third',
                'semester_no'   =>  3
            ]);
        Semester::create([
                'semester_name'  => 'fourth',
                'semester_no'   =>  4
            ]);
        Semester::create([
                'semester_name'  => 'fifth',
                'semester_no'   =>  5
            ]);
        Semester::create([
                'semester_name'  => 'sixth',
                'semester_no'   =>  6
            ]);
        Semester::create([
                'semester_name'  => 'seventh',
                'semester_no'   =>  7
            ]);
        Semester::create([
                'semester_name'  => 'eighth',
                'semester_no'   =>  8
            ]);
    }

} 