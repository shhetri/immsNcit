@extends('layout.student.default_template')

@section('title')
    @parent
    Home
@stop

@section('content')
{{ Form::open(['route' => 'view.marks', 'method' => 'get']) }}

<div class="col-md-8">
    <div class="col-md-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>Class</h3>
                <p>{{ Form::select('class_detail_id', $classes , null , ['class' => 'form-control chosen-select']) }}</p>
            </div>
            <div class="small-box-footer">Choose your class</div>
        </div>
</div>
<div class="col-md-6">
        <div class="small-box bg-teal">
            <div class="inner">
                <h3>Subject</h3>
                <p>{{ Form::select('subject_id', $subjects , null , ['class' => 'form-control chosen-select']) }}</p>
            </div>
            <div class="small-box-footer">Choose your subject</div>
        </div>
</div>
<div class="col-md-4 col-md-offset-4">
     {{ Form::submit('Submit', ['class' => 'form-control btn btn-primary']) }}
</div>
</div>
{{ Form::close() }}
<div class="col-md-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title text-center">Notice</h3>
        </div>
        <div class="panel-body">
            @if ($notices->isEmpty())
            <p>There are no notices to show.</p>
            @else
            @foreach ($notices as $notice)
            <div class="panel panel-info">
                <div class="panel-heading">{{ $notice->title }}</div>
                <div class="panel-body">{{ $notice->body }}</div>
                <div class="panel-footer">
                    <div class="text-right">
                        Date : {{ $notice->updated_at->format('F j, Y, g:i a') }}
                    </div>
                    <div class="text-right">
                        Posted By : {{ ucfirst($notice->teachers->first_name) }} {{ ucfirst($notice->teachers->last_name) }}
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        <div class="panel-footer text-center"><a href="{{ route('view.notices') }}" class="btn btn-block btn-primary">View All</a></div>
    </div>
</div>
@stop