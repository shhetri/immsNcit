@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Add Subject
@stop

@section('content')
<div class="row well well-lg">
    <div class="col-md-5">
        {{ Form::open(['route' => 'subjects.store', 'method' => 'post']) }}
        <div class="form-group {{ ($errors->has('subject_name'))? 'has-error' : '' }}">
            {{ Form::label('subject_name', 'Subject Name', ['class' => 'control-label']) }}
            {{ Form::text('subject_name', null, ['class' => 'form-control']) }}
            {{ $errors->first('subject_name','<p class="text-danger">:message</p>') }}
        </div>
        <div class="form-group {{ ($errors->has('course_code'))? 'has-error' : '' }}">
            {{ Form::label('course_code', 'Course Code', ['class' => 'control-label']) }}
            {{ Form::text('course_code', null, ['class' => 'form-control']) }}
            {{ $errors->first('course_code','<p class="text-danger">:message</p>') }}
        </div>
        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {{ link_to_route('subjects.index','Cancel',null,['class'=>'btn btn-warning']) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop