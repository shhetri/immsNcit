@extends('layout.teacher.default_template')

@section('title')
    @parent
    Add Notice
@stop

@section('content')
    <div class="well col-md-8 col-md-offset-2">
        <div class="col-md-9">
            {{ Form::open(['route' => 'notices.store', 'method' => 'post']) }}
            <div class="form-group {{ ($errors->has('title'))? 'has-error' : '' }}">
                {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control','maxlength'=>255]) }}
                {{ $errors->first('title','<p class="text-danger">:message</p>') }}
            </div>
            <div class="form-group {{ ($errors->has('body'))? 'has-error' : '' }}">
                {{ Form::label('body', 'Content', ['class' => 'control-label']) }}
                {{ Form::textarea('body', null, ['class' => 'form-control']) }}
                {{ $errors->first('body','<p class="text-danger">:message</p>') }}
            </div>
            <div class="form-group">
                {{ Form::submit('Add', ['class' => 'btn btn-primary']) }}
                {{ link_to_route('notices.index','Cancel',null,['class'=>'btn btn-warning']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
@stop