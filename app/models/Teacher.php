<?php
/**
 * @file Teacher.php
 * @brief This class is an Eloquent model for 'teachers' table
 *
 * Contains all the functions required to perform CRUD operations on 'teachers' table.
 * It also contains validation function to perform validation on the data that are to be filled in 'teachers' table.
 * @author Sumit Chhetri
 * @date 6/9/14
 * @bug No known bugs
 */
class Teacher extends Eloquent{

   /**
    * @var array Contains column names that can be filled by user
    */
    protected $fillable = ['first_name','last_name','email','phone_no','status'];

    /**
     * @var array Contains the validation errors
     */
    public $errors;

    /**
     * @var array Contains the validation rules
     */
    protected $rules = [
        'first_name'    =>  'required',
        'last_name'     =>  'required',
        'email'         =>  'required|email|unique:teachers',
        'phone_no'      =>  'required|numeric|digits:10',
    ];

    /**
     * @brief Checks if the input values are valid
     * @param $input
     * @param string $rule
     * @return bool
     */
    public function isValid($input, $rule = 'all')
    {
        if($rule == 'noEmail')
            $this->rules['email']='';

        $validator = Validator::make($input, $this->rules);

        if($validator->passes()){
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

}