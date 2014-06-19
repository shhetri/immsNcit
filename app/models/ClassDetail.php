<?php

    /**
     * @file   ClassDetail.php
     * @brief  This class is an Eloquent model for 'class_details' table
     *
     * Contains all the functions required to perform CRUD operations on 'class_details' table.
     * It also contains validation function to perform validation on the data that are to be filled in 'class_details' table.
     * @author Sumit Chhetri
     * @date   6/14/14
     * @bug    No known bugs
     */
    class ClassDetail extends Eloquent {

        /**
         * @var array Contains column names that can be filled by user
         */
        protected $fillable = ['semester_id', 'faculty_id', 'shift_id', 'title', 'batch'];

        /**
         * @brief Establish one-to-many relationship with Faculty model
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function faculty()
        {
            return $this->belongsTo('Faculty');
        }

        /**
         * @brief Establish one-to-many relationship with Semester model
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function semester()
        {
            return $this->belongsTo('Semester');
        }

        /**
         * @brief Establish one-to-many relationship with Shift model
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function shift()
        {
            return $this->belongsTo('Shift');
        }

        /**
         * @brief Validates the input data
         * @param     $input
         * @param int $id
         * @return bool
         */
        public function isValid($input, $id = 0)
        {
            $class = $this->whereTitle($input['title'])->whereBatch($input['batch'])->where('id', '!=', $id)->get();
            if ( ! $class->isEmpty() ) {
                return false;
            }

            return true;
        }
    }