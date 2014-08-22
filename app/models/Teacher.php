<?php

    /**
     * @file   Teacher.php
     * @brief  This class is an Eloquent model for 'teachers' table
     *
     * Contains all the functions required to perform CRUD operations on 'teachers' table.
     * It also contains validation function to perform validation on the data that are to be filled in 'teachers' table.
     * @author Sumit Chhetri
     * @date   6/9/14
     * @bug    No known bugs
     */
    class Teacher extends Eloquent {

        /**
         * @var array Contains column names that can be filled by user
         */
        protected $fillable = ['first_name', 'last_name', 'email', 'phone_no', 'status'];

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
            'email'      => 'required|email|unique:teachers,email',
            'phone_no'   => 'required|numeric|digits:10',
        ];

        /**
         * @brief Checks if the input values are valid
         * @param      $input
         * @param null $id
         * @return bool
         */
        public function isValid($input, $id = null)
        {
            if ( Request::isMethod('patch') ) {
                $this->rules['email'] = $this->rules['email'] . ',' . $id;
            }

            $validator = Validator::make($input, $this->rules);

            if ( $validator->passes() ) {
                return true;
            }
            $this->errors = $validator->errors();

            return false;
        }

        /**
         * @brief Creates many-to-many relationship with Subject Model and also join with classes using class_detail_id
         * @return mixed
         */
        public function subjects()
        {
            return $this->belongsToMany('Subject')->withPivot('class_detail_id')
                ->join('class_details', 'class_detail_id', '=', 'class_details.id');
            //->select('class_details.title AS pivot_title','class_details.batch AS pivot_batch');
        }

        /**
         * @brief Creates one-to-many relationship with Notice Model
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function notices()
        {
            return $this->hasMany('Notice');
        }

    }