@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Add Student
@stop

@section('content')
<div class="row well well-lg">
    <div class="col-md-6">
        @if (isset($file) && $file == true)
        {{ Form::open(['route' => 'students.store', 'method' => 'post', 'files'=>true]) }}
        {{ Form::hidden('hasFile','1') }}
        <div class="form-group {{ ($errors->has('first_name'))? 'has-error' : '' }}">
            {{ Form::label('file', 'Excel File', ['class' => 'control-label']) }}
            {{ Form::file('file') }}
            {{ $errors->first('file','<p class="text-danger">:message</p>') }}
        </div>
        @else
            {{ Form::open(['route' => 'students.store', 'method' => 'post']) }}
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
        @endif
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
    @if (isset($file) && $file == true)
        <div class="col-md-5 col-md-offset-1 alert-warning">
            <p class="help-block">Please fill the first row of the file with following headers.</p>
            <blockquote>
                <label class="text-info">First Name</label> | <label class="text-info">Last Name</label> | <span class="text-info">Roll No</span>
            </blockquote>
        </div>
    @if ( $errors->any() && ! $errors->has('file'))
        <div class="col-md-offset-1 col-md-5 alert-danger" style="margin-top: 15px; padding: 8px;">
            <label>Errors</label>
            <ul>
                @foreach($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
                {{ $errors->has('roll_no')? '<li>Error caused by Roll No - '.Session::get('roll_no').'</li>':'' }}
            </ul>
        </div>
    @endif

    @endif
</div>
@stop