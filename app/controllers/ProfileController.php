<?php

    /**
     * @file   ProfileController.php
     * @brief  This class manages profiles
     *
     * Contains functions which allow user to view, update profile information
     * @author Sumit Chhetri
     * @date   8/22/14
     * @bug    No known bugs
     */
    class ProfileController extends BaseController {

        private $teacher;
        private $registered = true;

        /**
         * @brief Initializes the teacher and registered variable
         */
        public function __construct()
        {
            $this->teacher = Session::get('teacher');
        }

        public function index()
        {
            return View::make('profiles.index')->with('registered', $this->registered)->with('teacher', $this->teacher);
        }


        public function edit()
        {
            return View::make('profiles.edit')->with('registered', $this->registered)->with('teacher', $this->teacher);
        }

        public function update()
        {
            $input = Input::all();
            if ( $this->teacher->isValid($input, $this->teacher->id) ) {
                try {
                    $user             = Sentry::findUserById(Session::get('userId'));
                    $user->email      = $input['email'];
                    $user->first_name = $input['first_name'];
                    $user->last_name  = $input['last_name'];
                    if ( $user->save() ) {
                        if ( $this->teacher->update($input) ) {
                            Session::put('first_name', $input['first_name']);
                            Session::put('last_name', $input['last_name']);
                            Session::put('email', $input['email']);

                            return Redirect::route('profiles.index')->with('success', 'Profile successfully updated.');
                        }

                    } else {
                        return Redirect::back()->withInput()->with('error', 'Profile not updated. Please try again.');
                    }
                } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
                    return Redirect::back()->withInput()->with('error', 'Profile not updated. The given email can\'t be used.');
                }
            }

            return Redirect::back()->withInput()->withErrors($this->teacher->errors);
        }

    }