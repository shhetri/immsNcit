<?php

    /**
     * @file   FacultyTableSeeder.php
     * @brief  Add the default data in 'faculties' table
     * @author Sumit Chhetri
     * @date   6/7/14
     * @bug    No known bugs
     */
    class FacultyTableSeeder extends Seeder {

        public function run()
        {
            Eloquent::unguard();

            Faculty::create([
                'faculty_name'        => 'BEIT',
                'faculty_description' => 'Bachelors of Engineering in Information Technology'
            ]);

            Faculty::create([
                'faculty_name'        => 'BCE',
                'faculty_description' => 'Bachelors of Computer Engineering'
            ]);

            Faculty::create([
                'faculty_name'        => 'BSE',
                'faculty_description' => 'Bachelors of Software Engineering'
            ]);

            Faculty::create([
                'faculty_name'        => 'BECE',
                'faculty_description' => 'Bachelors of Electronics and Communication Engineering'
            ]);

            Faculty::create([
                'faculty_name'        => 'BBA',
                'faculty_description' => 'Bachelors of Business Administration'
            ]);
        }
    }