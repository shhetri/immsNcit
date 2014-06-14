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

            Route::resource('subjects', 'SubjectController');
        }
    );

    Route::when('*', 'csrf', ['post', 'put', 'patch', 'delete']);

Route::any('/',function()
{
    return "anything";
});