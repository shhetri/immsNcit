<?php

    /**
     * @file   Student.php
     * @brief  This class is an Eloquent model for 'students' table
     *
     * Contains all the functions required to perform CRUD operations on 'students' table.
     * It also contains validation function to perform validation on the data that are to be filled in 'students' table.
     * @author Sumit Chhetri
     * @date   6/25/14
     * @bug    No known bugs
     */
    class Student extends Eloquent {

        /**
         * @var array Contains column names that can be filled by user
         */
        protected $fillable = ['first_name', 'last_name', 'roll_no', 'batch', 'faculty_id', 'shift_id'];

        /**
         * @var array Contains the validation errors
         */
        public $errors;

        /**
         * @var array Contains the validation rules
         */
        protected $rules = [
            'first_name' => 'required',
            'last_name'  => 'required',
            'roll_no'    => 'required|integer|digits:5|unique:students,roll_no',
        ];

        /**
         * @var array Contains the validation rule for file
         */
        protected $fileRule = [
            'file' => 'required|mimes:xls,xlsx|max:100'
        ];

        /**
         * @var array Contains the custom validation messages
         */
        protected $custom_message = [
            'required' => 'All columns in the row should be filled. There are some empty columns.',
            'integer'  => 'All Roll No should be an integer value. Decimal is not allowed.',
            'digits'   => 'All Roll No should be exactly 5 digits.',
            'unique'   => 'Roll No should be unique. No two students should have same Roll No.'
        ];

        /**
         * @brief Create many-to-one relationship with Faculty model
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function faculty()
        {
            return $this->belongsTo('Faculty');
        }

        /**
         * @brief Create many-to-one relationship with Shift model
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function shift()
        {
            return $this->belongsTo('Shift');
        }

        /**
         * @brief Checks if the input values are valid
         * @param      $input
         * @param null $id
         * @return bool
         */
        public function isValid($input, $id = null)
        {
            if ( $input['hasFile'] == 1 ) {
                $validator = Validator::make($input, $this->rules, $this->custom_message);
            } else {
                if ( Request::isMethod('patch') ) {
                    $this->rules['roll_no'] = $this->rules['roll_no'] . ',' . $id;
                }
                $validator = Validator::make($input, $this->rules);
            }
            if ( $validator->fails() ) {
                $this->errors = $validator->errors();

                return false;
            }

            return true;
        }

        /**
         * @brief Checks if the input file is valid
         * @param $input
         * @return bool
         */
        public function isValidFile($input)
        {
            $validator = Validator::make($input, $this->fileRule);
            if ( $validator->fails() ) {
                $this->errors = $validator->errors();

                return false;
            }

            return true;
        }

        /**
         * @brief Create one-to-many relationship with Mark model
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function marks()
        {
            return $this->hasMany('Mark');
        }

    }