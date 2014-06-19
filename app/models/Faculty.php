<?php

    /**
     * @file   Faculty.php
     * @brief  This class is an Eloquent model for 'faculties' table
     * @author SHhetri
     * @date   5/24/14
     * @bug    No known bugs
     */
    class Faculty extends Eloquent {

        /**
         * @var array Contains column names that can be filled by user
         */
        protected $fillable = ['faculty_name', 'faculty_description'];

        /**
         * @brief Establish many-to-one relationship with ClassDetail model
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function classDetail()
        {
            return $this->hasMany('ClassDetail');
        }

        /**
         * @brief This is an accessor (getter) which returns the full name of staff combining first name and last name
         * @return string
         */
        public function getFacultyWithDescriptionAttribute()
        {
            return $this->attributes['faculty_name'] . " : " . $this->attributes['faculty_description'];
        }

    }