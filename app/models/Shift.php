<?php

    /**
     * @file   Shift.php
     * @brief  This class is an Eloquent model for 'shifts' table
     * @author Sumit Chhetri
     * @date   6/9/14
     * @bug    No known bugs
     */
    class Shift extends Eloquent {

        /**
         * @var array Contains column names that can be filled by user
         */
        protected $fillable = ['shift'];

        /**
         * @brief Establish many-to-one relationship with ClassDetail model
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function classDetail()
        {
            return $this->hasMany('ClassDetail');
        }
    }