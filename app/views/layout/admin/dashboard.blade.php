@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Dashboard
@stop
@section('content')
    <img src="{{ asset('img/admin_dashboard.jpg') }}" class="img img-responsive">
@stop