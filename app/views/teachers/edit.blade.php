@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Edit Teacher
@stop

@section('content')
<div class="row well well-lg">
    <div class="col-md-5">
        {{ Form::model($teacher,['route' => ['teachers.update',$teacher->id], 'method' => 'PATCH']) }}
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
            {{ Form::label('status', 'Status', ['class' => 'control-label']) }}
            {{ Form::select('status', ['Active'=>'Active','Inactive'=>'Inactive'] , null , ['class' => 'form-control chosen-select']) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {{ link_to_route('teachers.index','Cancel',null,['class'=>'btn btn-warning']) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop