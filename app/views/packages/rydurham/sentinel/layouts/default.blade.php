<!DOCTYPE html>
<html data-ng-app="app" lang="en">
	<head>
		<meta charset="utf-8" />
		<title> 
			@section('title') 
			@show 
		</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Bootstrap 3.0: Latest compiled and minified CSS -->
		<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"> -->
		<link rel="stylesheet" href="{{ asset('packages/rydurham/sentinel/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('packages/rydurham/sentinel/css/simple-sidebar.css') }}">

        <!-- Optional theme -->
        <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css"> -->
        <link rel="stylesheet" href="{{ asset('css/chosen.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select.css') }}">
        <link rel="stylesheet" href="{{ asset('css/myStyle.css') }}">

		<style>
		@section('styles')
			body {
				padding-top: 60px;
			}
		@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	
	</head>

	<body>
		

		<!-- Navbar -->
		<div class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" style="padding: 0 20px 0 10px" href="{{ URL::route('admin.dashboard') }}"><img src="{{ asset('img/logo.png') }}" class="img img-responsive" width="48px" height="48px"></a>
	        </div>
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
				@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
					<li {{ (Request::is('users*') ? 'class="active"' : '') }}><a href="{{ URL::action('Sentinel\UserController@index') }}">Users</a></li>
				    @if(Sentry::getUser()->hasAccess('super admin'))
                        <li {{ (Request::is('groups*') ? 'class="active"' : '') }}><a href="{{ URL::action('Sentinel\GroupController@index') }}">Groups</a></li>
				    @endif
                @endif
	          </ul>
	          <ul class="nav navbar-nav navbar-right">
	            @if (Sentry::check())
				<li {{ (Request::is('users/show/' . Session::get('userId')) ? 'class="active"' : '') }}>
                  <a href="{{ Sentry::getUser()->hasAccess('admin')? '/users/'.Session::get('userId') : route('profiles.index') }}">@if(Session::get('first_name') && Session::get('last_name')) {{ Session::get('first_name').' '.Session::get('last_name') }} @else {{ Session::get('email') }} @endif</a>
                 </li>
                    @if (Sentry::getUser()->hasAccess('admin'))
                    <li {{ (Request::is('register') ? 'class="active"' : '') }}><a href="{{ URL::route('Sentinel\register') }}">Register</a></li>
                    @endif
                <li><a href="{{ route('teacher.dashboard') }}">Teacher Dashboard</a></li>
                <li><a href="{{ URL::route('Sentinel\logout') }}">Logout</a></li>
				@endif
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>
		<!-- ./ navbar -->
        @if(Sentry::check() && Sentry::getUser()->hasAccess('admin'))
            <div id="wrapper">
                <!-- Sidebar -->
                <div id="sidebar-wrapper">
                    <ul class="sidebar-nav">
                        <li class="sidebar-brand">
                            <h3 class="text-success">Manage</h3>
                        </li>
                        <li {{ (Request::is('teachers*'))? 'class="active"' : '' }}>
                            <a href="{{ route('teachers.index') }}">Teacher</a>
                        </li>
                        <li {{ (Request::is('subjects*'))? 'class="active"' : '' }}>
                             <a href="{{ route('subjects.index') }}">Subject</a>
                        </li>
                        <li {{ (Request::is('classes*'))? 'class="active"' : '' }}>
                            <a href="{{ route('classes.index') }}">Class</a>
                        </li>
                        <li {{ (Request::is('students*'))? 'class="active"' : '' }}>
                            <a href="{{ route('students.index') }}">Student</a>
                        </li>
                        <li>
                            <a href="#">About</a>
                        </li>
                        <li>
                            <a href="#">Services</a>
                        </li>
                        <li>
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </div>
                <div id="page-content-wrapper">
                    <div class="page-content inset">
                        <!-- Notifications -->
                        @include('Sentinel::layouts/notifications')
                        <!-- ./ notifications -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Content -->
                                @yield('content')
                                <!-- ./ content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container">
                <!-- Notifications -->
                @include('Sentinel::layouts/notifications')
                <!-- ./ notifications -->
                <!-- Content -->

                @yield('content')
                <!-- ./ content -->
            </div>
        @endif

		<!-- Javascripts
		================================================== -->
		<script src="{{ asset('packages/rydurham/sentinel/js/jquery-2.0.2.min.js') }}"></script>
		<script src="{{asset('js/angular.min.js')}}"></script>
		<script src="{{asset('js/angular-sanitize.js')}}"></script>
		<script src="{{asset('js/chosen.jquery.min.js')}}"></script>
		<script src="{{asset('js/select.js')}}"></script>
		<script src="{{asset('js/spin.min.js')}}"></script>
		<script src="{{asset('app/app.js')}}"></script>
		<script src="{{ asset('packages/rydurham/sentinel/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('packages/rydurham/sentinel/js/bootbox.min.js') }}"></script>
		<script src="{{ asset('packages/rydurham/sentinel/js/restfulizer.js') }}"></script>
		<!-- Thanks to Zizaco for the Restfulizer script.  http://zizaco.net  -->
        <script>
            $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
        </script>
	</body>
</html>
