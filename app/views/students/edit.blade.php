@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Edit Student
@stop

@section('content')
<div class="row well well-lg">
    <div class="col-md-6">
        {{ Form::model($student,['route' => ['students.update',$student->id], 'method' => 'PATCH']) }}
        {{ Form::hidden('hasFile','0') }}
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
        <div class="form-group {{ ($errors->has('roll_no'))? 'has-error' : '' }}">
            {{ Form::label('roll_no', 'Roll No', ['class' => 'control-label']) }}
            {{ Form::text('roll_no', null, ['class' => 'form-control']) }}
            {{ $errors->first('roll_no','<p class="text-danger">:message</p>') }}
        </div>
        <div class="form-group">
            {{ Form::label('faculty_id', 'Faculty', ['class' => 'control-label']) }}
            {{ Form::select('faculty_id', $faculties, null, ['class' => 'form-control chosen-select']) }}
        </div>
        <div class="form-group">
            {{ Form::label('shift_id', 'Shift', ['class' => 'control-label']) }}
            {{ Form::select('shift_id', $shifts, null, ['class' => 'form-control chosen-select']) }}
        </div>
        <div class="form-group">
            {{ Form::label('batch', 'Batch', ['class' => 'control-label']) }}
            {{ Form::select('batch', $batches, null, ['class' => 'form-control chosen-select']) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {{ link_to_route('students.index','Cancel',null,['class'=>'btn btn-warning']) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop