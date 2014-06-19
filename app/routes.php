<?php

    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It's a breeze. Simply tell Laravel the URIs it should respond to
    | and give it the Closure to execute when that URI is requested.
    |
    */

    Route::get('/', function () {
        return View::make('hello');
    });

    Route::group(
        ['before' => 'Sentinel\auth'],
        function () {
            Route::get('teacher/dashboard', [
                'as' => 'teacher.dashboard',
                function () {
                    return View::make('layout.teacher.dashboard');
                }
            ]);
        }
    );

    Route::group(
        ['before' => 'Sentinel\auth|check_role'],
        function () {
            Route::get('admin/dashboard', [
                'as' => 'admin.dashboard',
                function () {
                    return View::make('layout.admin.dashboard');
                }
            ]);

            Route::resource('teachers', 'TeacherController');
            Route::get('all/teachers',[
                'as'    =>  'all.teachers',
                'uses'  =>  'TeacherController@getAllTeachers'
            ]);

            Route::resource('subjects', 'SubjectController');
            Route::get('all/subjects',[
                'as'    =>  'all.subjects',
                'uses'  =>  'SubjectController@getAllSubjects'
            ]);

            Route::resource('classes', 'ClassDetailController');
            Route::get('all/classes',[
                'as'    =>  'all.classes',
                'uses'  =>  'ClassDetailController@getAllClasses'
            ]);
        }
    );

    Route::when('*', 'csrf', ['post', 'put', 'patch', 'delete']);

    Route::any('/', function () {
        return "anything";
    });