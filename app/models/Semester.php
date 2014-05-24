<?php
/**
 * @file Semester.php
 * @brief This class is an Eloquent model for 'semesters' table
 *
 * Contains all the functions required to perform CRUD operations on 'semesters' table.
 * @author SHhetri
 * @date 5/24/14
 * @bug No known bugs
 */

class Semester extends Eloquent{

   /**
    * @var array Contains column names that can be filled by user
    */
    protected $fillable = ['semester_name','semester_no'];

}