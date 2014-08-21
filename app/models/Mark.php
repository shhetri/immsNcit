<?php

    /**
     * @file   Mark.php
     * @brief  This class is an Eloquent model for 'marks' table
     *
     * Contains all the functions required to perform CRUD operations on 'marks' table.
     * @author Sumit Chhetri
     * @date   8/20/14
     * @bug    No known bugs
     */
    class Mark extends Eloquent {

        /**
         * @var array Contains column names that can be filled by user
         */
        protected $guarded = ['id', 'created_at', 'updated_at'];

    }