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
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.tableTools.min.css') }}">

    <!-- Optional theme -->
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css"> -->
    <link rel="stylesheet" href="{{ asset('css/chosen.min.css') }}">
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
            <a class="navbar-brand" style="padding: 0 20px 0 10px" href="{{ URL::route('view.home') }}"><img src="{{ asset('img/logo.png') }}" class="img img-responsive" width="48px" height="48px"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="{{ Request::is('view/teachers')? 'active' : '' }}"><a href="{{ route('view.teachers') }}">List Teachers</a></li>
                <li class="{{ Request::is('view/notices')? 'active' : '' }}"><a href="{{ route('view.notices') }}">Notice</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- ./ navbar -->
<div id="wrapper">
    <div id="page-content-wrapper">
        <div class="page-content inset">
            <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Notifications -->
                    @include('Sentinel::layouts/notifications')
                    <!-- ./ notifications -->
                    <!-- Content -->
                    @yield('content')
                    <!-- ./ content -->
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Javascripts
================================================== -->
<script src="{{ asset('packages/rydurham/sentinel/js/jquery-2.0.2.min.js') }}"></script>
<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/angular-sanitize.js')}}"></script>
<script src="{{asset('js/chosen.jquery.min.js')}}"></script>
<script src="{{asset('js/spin.min.js')}}"></script>
<script src="{{asset('app/view_teacherDetail.js')}}"></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('js/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('packages/rydurham/sentinel/js/bootstrap.min.js') }}"></script>
<script>
    $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
</script>
@yield('dataTable_script')
</body>
</html>
