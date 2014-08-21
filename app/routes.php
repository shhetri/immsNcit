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

    Route::group(
        ['before' => 'Sentinel\auth'],
        function () {
            Route::get('teacher/dashboard', [
                'as'   => 'teacher.dashboard',
                'uses' => 'DashboardController@teacherDashboard'
            ]);

            Route::get('teacher/{batch}/subject', [
                'as'   => 'teacher.subject',
                'uses' => 'DashboardController@teachersSubjects'
            ]);

            Route::get('marks/{classDetailId}/{subjectId}', [
                'as'   => 'subject.marks',
                'uses' => 'MarkController@index'
            ]);

            Route::post('marks', [
                'as'   => 'marks.store',
                'uses' => 'MarkController@store'
            ]);

            Route::patch('marks', [
                'as'   => 'marks.update',
                'uses' => 'MarkController@update'
            ]);

            Route::post('marks/{classDetailId}/{subjectId}/export', [
                'as'   => 'marks.export',
                'uses' => 'MarkController@export'
            ]);
        }
    );

    Route::group(
        ['before' => 'Sentinel\auth|check_role'],
        function () {
            Route::get('home', [
                'as'   => 'home',
                'uses' => 'DashboardController@adminDashboard'
            ]);
            Route::get('admin/dashboard', [
                'as'   => 'admin.dashboard',
                'uses' => 'DashboardController@adminDashboard'
            ]);

            Route::resource('teachers', 'TeacherController');
            Route::get('all/teachers', [
                'as'   => 'all.teachers',
                'uses' => 'TeacherController@getAllTeachers'
            ]);
            Route::get('teachers/{teacherId}/register', [
                'as'   => 'teachers.register',
                'uses' => 'TeacherController@register'
            ]);

            Route::resource('subjects', 'SubjectController');
            Route::get('all/subjects', [
                'as'   => 'all.subjects',
                'uses' => 'SubjectController@getAllSubjects'
            ]);
            Route::get('subjects/{subjects}/teachers', [
                'as'   => 'subjects.teachers',
                'uses' => 'SubjectController@assignedTo'
            ]);
            Route::get('subjects/{subjects}/assigned/info', [
                'as'   => 'subjects.teachers.assigned.info',
                'uses' => 'SubjectController@getInfo'
            ]);

            Route::resource('classes', 'ClassDetailController');
            Route::get('all/classes', [
                'as'   => 'all.classes',
                'uses' => 'ClassDetailController@getAllClasses'
            ]);

            Route::resource('students', 'StudentController');
            Route::get('all/faculty/shift/batch', 'StudentController@getListsOfFacultyShiftAndBatch');
            Route::get('all/students/{facultyId}/{shiftId}/{batch}', 'StudentController@getStudents');
            Route::get('loading/spinner',
                [
                    'before' => 'ajax',
                    function () {
                        return View::make('loading');
                    }
                ]);

            Route::resource('teachers.subjects', 'AssignController', ['except' => ['show', 'update', 'edit']]);
        }
    );

    Route::when('*', 'csrf', ['post', 'put', 'patch', 'delete']);

    Route::any('/', function () {
        return "anything";
    });

    //DB::listen(function($sql){
    //    var_dump($sql);
    //});