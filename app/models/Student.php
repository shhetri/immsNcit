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

        public $errors;

        protected $rules = [
            'first_name' => 'required',
            'last_name'  => 'required',
            'roll_no'    => 'required|integer|digits:5|unique:students,roll_no',
        ];

        protected $fileRule =[
            'file'       => 'required|mimes:xls|max:50'
        ];

        public function faculty()
        {
            return $this->belongsTo('Faculty');
        }

        public function shift()
        {
            return $this->belongsTo('Shift');
        }

        public function isValid($input)
        {
            $validator = Validator::make($input,$this->rules);
            if($validator->fails()){
                $this->errors = $validator->errors();
                return false;
            }
            return true;
        }

        public function isValidFile($input)
        {
            $validator = Validator::make($input,$this->fileRule);
            if($validator->fails()){
                $this->errors = $validator->errors();
                return false;
            }
            return true;
        }

    }