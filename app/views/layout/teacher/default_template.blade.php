<!DOCTYPE html>
<html>
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
            <a class="navbar-brand" style="padding: 0 20px 0 10px" href="{{ URL::route('teacher.dashboard') }}"><img src="{{ asset('img/logo.png') }}" class="img img-responsive" width="48px" height="48px"></a>
        </div>
        <div class="collapse navbar-collapse">
            @if($registered == true)
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('profiles*')? 'active' : '' }}"><a href="{{ route('profiles.index') }}">Profile</a></li>
                <li  class="{{ Request::is('notices*')? 'active' : '' }}"><a href="{{ route('notices.index') }}">Notice</a></li>
            </ul>
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if($registered == true)
                    <li><a href="{{ route('profiles.index') }}">{{ Session::get('first_name').' '.Session::get('last_name') }}</a></li>
                @else
                    <li><a>{{ Session::get('email') }}</a></li>
                @endif
                @if (Sentry::getUser()->hasAccess('admin'))
                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                @endif
                <li><a href="{{ URL::route('Sentinel\logout') }}">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- ./ navbar -->
@if (isset($batches))
<div id="wrapper">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <h3 class="text-success">Subjects (Batch)</h3>
            </li>
                @if (count($batches)>0)
                    @foreach ($batches as $batch)
                        <li class="{{ Request::is('teacher/'.$batch.'/subject')? 'active':'' }}"><a href="{{ route('teacher.subject',$batch) }}">{{ $batch }}</a></li>
                    @endforeach
                @else
                    <li><a>No subjects assigned.</a></li>
                @endif
        </ul>
    </div>
@else
    <div id="wrapper" style="padding-left: 0">
@endif
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
                    <!--footer-->
                    @yield('footer')
                    <!-- end of footer-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Javascripts
================================================== -->
<script src="{{ asset('packages/rydurham/sentinel/js/jquery-2.0.2.min.js') }}"></script>
<script src="{{asset('js/jquery.form-validator.min.js')}}"></script>
<script src="{{ asset('packages/rydurham/sentinel/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('packages/rydurham/sentinel/js/bootbox.min.js') }}"></script>
<script src="{{ asset('packages/rydurham/sentinel/js/restfulizer.js') }}"></script>
<!-- Thanks to Zizaco for the Restfulizer script.  http://zizaco.net  -->
    <script>
        $.validate();
    </script>
</body>
</html>
