<?php

    /**
     * @file   Notice.php
     * @brief  This class is an Eloquent model for 'notices' table
     *
     * Contains all the functions required to perform CRUD operations on 'notices' table.
     * It also contains validation function to perform validation on the data that are to be filled in 'notices' table.
     * @author Sumit Chhetri
     * @date   8/21/14
     * @bug    No known bugs
     */
    class Notice extends Eloquent {

        /**
         * @var array Contains column names that can be filled by user
         */
        protected $fillable = ['title', 'body', 'teacher_id'];

        /**
         * @var array Contains validation errors
         */
        public $errors;

        /**
         * @var array Contains rules for validation
         */
        protected $rules = [
            'title' => 'required|max:255',
            'body'  => 'required'
        ];

        /**
         * @brief Check if the input is valid
         * @param $input
         * @return bool
         */
        public function isValid($input)
        {
            $validation = Validator::make($input, $this->rules);
            if ( $validation->fails() ) {
                $this->errors = $validation->errors();

                return false;
            }

            return true;
        }

        /**
         * @brief Establish many-to-one relationship with Teacher model
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function teachers()
        {
            return $this->belongsTo('Teacher','teacher_id');
        }

    }