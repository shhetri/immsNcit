<?php
/**
 * @file Faculty.php
 * @brief This class is an Eloquent model for 'faculties' table
 * @author SHhetri
 * @date 5/24/14
 * @bug No known bugs
 */
class Faculty extends Eloquent{

    /**
     * @var array Contains column names that can be filled by user
     */
    protected $fillable = ['faculty_name'];

} 