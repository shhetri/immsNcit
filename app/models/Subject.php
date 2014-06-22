<?php

    /**
     * @file
     * @brief  This class is an Eloquent model for 'subjects' table
     *
     * Contains all the functions required to perform CRUD operations on 'subjects' table.
     * It also contains validation function to perform validation on the data that are to be filled in 'subjects' table.
     * @author Sumit Chhetri
     * @date   6/10/14
     * @bug    No known bugs
     */
    class Subject extends Eloquent {

        /**
         * @var array Contains column names that can be filled by user
         */
        protected $fillable = ['subject_name', 'course_code'];

        /**
         * @var array Contains the validation errors
         */
        public $errors;

        /**
         * @var array Contains validation rules
         */
        protected $rules = [
            'subject_name' => 'required',
            'course_code'  => 'required|alpha_num_spaces|unique:subjects,course_code'
        ];

        /**
         * @brief Checks if the input values are valid
         * @param      $input
         * @param null $id
         * @return bool
         */
        public function isValid($input, $id = null)
        {
            if ( Request::isMethod('patch') )
                $this->rules['course_code'] = $this->rules['course_code'] . ',' . $id;
            $validator = Validator::make($input, $this->rules);
            if ( $validator->passes() )
                return true;
            $this->errors = $validator->errors();

            return false;
        }

        /**
         * @brief Creates many-to-many relationship with subjects and also join with classes using class_detail_id
         * @return mixed
         */
        public function teachers()
        {
            return $this->belongsToMany('Teacher')->withPivot('class_detail_id')
                ->join('class_details', 'class_detail_id', '=', 'class_details.id');
            //->select('class_details.title AS pivot_title','class_details.batch AS pivot_batch');
        }
    }