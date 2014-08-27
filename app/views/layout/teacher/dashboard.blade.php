@extends('layout.teacher.default_template')

@section('title')
    @parent
    Dashboard
@stop

@section('content')
    @if($registered == true)
        <div class="col-md-7">
            <img src="{{ asset('img/teacher_dashboard.jpg') }}" class="img img-responsive img-circle">
        </div>
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Notice</h3>
                </div>
                <div class="panel-body">
                    @if ($notices->isEmpty())
                        <p>There are no notices to show. <a href="{{ route('notices.create') }}"><strong>Add</strong></a> new notice.</p>
                    @else
                        @foreach ($notices as $notice)
                            <div class="panel panel-info">
                                <div class="panel-heading">{{ $notice->title }}</div>
                                <div class="panel-body">{{ $notice->body }}</div>
                                <div class="panel-footer text-right">Date : {{ $notice->updated_at->format('F j, Y, g:i a') }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="panel-footer text-center"><a href="{{ route('notices.index') }}" class="btn btn-block btn-primary">View All</a></div>
            </div>
        </div>

    @else
        <h3 class="alert alert-danger text-center">You are not registered as a teacher.</h3>
    @endif
@stop