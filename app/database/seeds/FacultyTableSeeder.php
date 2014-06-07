<?php

/**
 * @file FacultyTableSeeder.php
 * @brief Add the default data in 'faculties' table
 * @author Sumit Chhetri
 * @date 6/7/14
 * @bug No known bugs
 */
class FacultyTableSeeder extends Seeder{

    public function run()
    {
        Eloquent::unguard();

        Faculty::create([
                'faculty_name'  =>  'BEIT'
            ]);

        Faculty::create([
                'faculty_name'  =>  'BCE'
            ]);

        Faculty::create([
                'faculty_name'  =>  'BSE'
            ]);

        Faculty::create([
                'faculty_name'  =>  'BECE'
            ]);

        Faculty::create([
                'faculty_name'  =>  'BBA'
            ]);
    }
} 