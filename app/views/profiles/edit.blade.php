@extends('layout.teacher.default_template')

@section('title')
    @parent
    Edit Profile
@stop

@section('content')
<div class="well col-md-8 col-md-offset-2">
    <div class="col-md-9">
        {{ Form::model($teacher,['route' => 'profiles.update', 'method' => 'PATCH']) }}
        <div class="form-group {{ ($errors->has('first_name'))? 'has-error' : '' }}">
            {{ Form::label('first_name', 'First Name', ['class' => 'control-label']) }}
            {{ Form::text('first_name', null, ['class' => 'form-control']) }}
            {{ $errors->first('first_name','<p class="text-danger">:message</p>') }}
        </div>
        <div class="form-group {{ ($errors->has('last_name'))? 'has-error' : '' }}">
            {{ Form::label('last_name', 'Last Name', ['class' => 'control-label']) }}
            {{ Form::text('last_name', null, ['class' => 'form-control']) }}
            {{ $errors->first('last_name','<p class="text-danger">:message</p>') }}
        </div>
        <div class="form-group {{ ($errors->has('email'))? 'has-error' : '' }}">
            {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
            {{ Form::email('email', null, ['class' => 'form-control']) }}
            {{ $errors->first('email','<p class="text-danger">:message</p>') }}
        </div>
        <div class="form-group {{ ($errors->has('phone_no'))? 'has-error' : '' }}">
            {{ Form::label('phone_no', 'Phone No.', ['class' => 'control-label']) }}
            {{ Form::text('phone_no', null, ['class' => 'form-control']) }}
            {{ $errors->first('phone_no','<p class="text-danger">:message</p>') }}
        </div>
        <div class="form-group">
            {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {{ link_to_route('profiles.index','Cancel',null,['class'=>'btn btn-warning']) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop