<?php

    /*
    |--------------------------------------------------------------------------
    | Application & Route Filters
    |--------------------------------------------------------------------------
    |
    | Below you will find the "before" and "after" events for the application
    | which may be used to do any work before or after a request into your
    | application. Here you may also register your custom route filters.
    |
    */

    Route::filter(
        'check_loggedIn',
        function () {
            if ( Sentry::check() ) {
                return Redirect::route('admin.dashboard');
            }
        }
    );

    Route::filter(
        'check_role',
        function () {
            if ( ! Sentry::getUser()->hasAccess('super admin') && ! Sentry::getUser()->hasAccess('admin') ) {
                Session::reflash();

                return Redirect::route('teacher.dashboard');
            }
        }
    );

    Route::filter('check_super_admin', function () {
        if ( ! Sentry::getUser()->hasAccess('super admin') ) {
            return Redirect::route('admin.dashboard');
        }
    });

    Route::filter('ajax', function () {
        if ( ! Request::ajax() ) {
            App::abort(404);
        }
    });

    Route::filter('class.subject.isEmpty', function ($id) {
        if ( DB::table('class_details')->count() == 0 || DB::table('subjects')->count() == 0 ) {
            return Redirect::back()->with('error', 'Subject or Class not added. Please add them first.');
        }
    });

    Route::filter('check_userId', function () {
        if ( ! Sentry::getUser()->hasAccess('super admin') && ! Sentry::getUser()->hasAccess('admin') ) {
            if ( Route::input('users') != Session::get('userId') )
                return Redirect::route('teacher.dashboard');
        }
    });

    Route::filter('check_regAct', function () {
        $teacher = Teacher::where('email', '=', Session::get('email'))->distinct()->first();
        if ( $teacher == null || $teacher->status == "Inactive" ) {
            $registered = false;

            return View::make('layout.teacher.dashboard', compact('registered'));
        }
        Session::put('teacher', $teacher);
    });

    App::before(function ($request) {
        //
    });


    App::after(function ($request, $response) {
        $response->header("Pragma", "no-cache");
        $response->header("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0");
    });

    /*
    |--------------------------------------------------------------------------
    | Authentication Filters
    |--------------------------------------------------------------------------
    |
    | The following filters are used to verify that the user of the current
    | session is logged into this application. The "basic" filter easily
    | integrates HTTP Basic authentication for quick, simple checking.
    |
    */

    Route::filter('auth', function () {
        if ( Auth::guest() ) return Redirect::guest('login');
    });


    Route::filter('auth.basic', function () {
        return Auth::basic();
    });

    /*
    |--------------------------------------------------------------------------
    | Guest Filter
    |--------------------------------------------------------------------------
    |
    | The "guest" filter is the counterpart of the authentication filters as
    | it simply checks that the current user is not logged in. A redirect
    | response will be issued if they are, which you may freely change.
    |
    */

    Route::filter('guest', function () {
        if ( Auth::check() ) return Redirect::to('/');
    });

    /*
    |--------------------------------------------------------------------------
    | CSRF Protection Filter
    |--------------------------------------------------------------------------
    |
    | The CSRF filter is responsible for protecting your application against
    | cross-site request forgery attacks. If this special token in a user
    | session does not match the one given in this request, we'll bail.
    |
    */

    Route::filter('csrf', function () {
        if ( Session::token() != Input::get('_token') ) {
            throw new Illuminate\Session\TokenMismatchException;
        }
    });