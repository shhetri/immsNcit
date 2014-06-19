@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Edit Class
@stop

@section('content')
<div class="row well well-lg">
    <div class="col-md-6">
        {{ Form::model($class_details,['route' => ['classes.update',$class_details->id], 'method' => 'PATCH']) }}
        <div class="form-group">
            {{ Form::label('faculty_id', 'Faculty', ['class' => 'control-label']) }}
            {{ Form::select('faculty_id', $faculties , null , ['class' => 'form-control chosen-select']) }}
        </div>
        <div class="form-group">
            {{ Form::label('semester_id', 'Semester', ['class' => 'control-label']) }}
            {{ Form::select('semester_id', $semesters , null , ['class' => 'form-control chosen-select']) }}
        </div>
        <div class="form-group">
            {{ Form::label('shift_id', 'Shift', ['class' => 'control-label']) }}
            {{ Form::select('shift_id', $shifts , null , ['class' => 'form-control chosen-select']) }}
        </div>
        <div class="form-group">
            {{ Form::label('batch', 'Batch', ['class' => 'control-label']) }}
            {{ Form::select('batch', $batches , null , ['class' => 'form-control chosen-select']) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {{ link_to_route('classes.index','Cancel',null,['class'=>'btn btn-warning']) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop