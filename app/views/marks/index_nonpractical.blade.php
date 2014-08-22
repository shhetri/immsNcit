@extends('layout.teacher.default_template')

@section('title')
    @parent
    {{ $class_detail->title }} {{ $class_detail->batch }} - {{ Str::upper($subject->subject_name) }} Marks
@stop

@section('content')
<div>
    <label class="alert alert-info">{{ Str::upper($subject->subject_name) }}</label>
    <label class="alert alert-warning pull-right">{{ $class_detail->title }} ({{ $class_detail->batch }})</label>
</div>
@if( ! $studentsWithMarks->isEmpty())
    @if ($count>0)
    {{ Form::open(['route' => 'marks.update', 'method' => 'PATCH']) }}
    <table class="table table-responsive table-bordered table-hover">
        <tr>
            <th>Name</th>
            <th>Roll No</th>
            <th>Unit Test (12)</th>
            <th>Assessment (24)</th>
            <th>Tutorial (10)</th>
            <th>Attendance (4)</th>
            <th>Total (50)</th>
        </tr>
        @foreach ($studentsWithMarks as $swm)
        <tr>
            <td>{{ ucfirst($swm->first_name) }} {{ ucfirst($swm->last_name) }}</td>
            <td>{{ $swm->roll_no }}</td>
            <td>{{ Form::text('mark['.$swm->id.'][unit_test]',$swm->marks->isEmpty() ? 0 : $swm->marks[0]->unit_test, ['class' => 'form-control','size'=>2,'data-validation'=>'number','data-validation-allowing'=>'float,range[0;12]','data-validation-error-msg'=>'Number between 0 & 12']) }}</td>
            <td>{{ Form::text('mark['.$swm->id.'][assessment]',$swm->marks->isEmpty() ? 0 : $swm->marks[0]->assessment, ['class' => 'form-control','size'=>2,'data-validation'=>'number','data-validation-allowing'=>'float,range[0;24]','data-validation-error-msg'=>'Number between 0 & 24']) }}</td>
            <td>{{ Form::text('mark['.$swm->id.'][tutorial]',$swm->marks->isEmpty() ? 0 : $swm->marks[0]->tutorial, ['class' => 'form-control','size'=>2,'data-validation'=>'number','data-validation-allowing'=>'float,range[0;10]','data-validation-error-msg'=>'Number between 0 & 10']) }}</td>
            <td>{{ Form::text('mark['.$swm->id.'][attendance]',$swm->marks->isEmpty() ? 0 : $swm->marks[0]->attendance, ['class' => 'form-control','size'=>2,'data-validation'=>'number','data-validation-allowing'=>'float,range[0;4]','data-validation-error-msg'=>'Number between 0 & 4']) }}</td>
            <td>
                {{ $swm->marks->isEmpty() ? 0 : $total[$swm->id] = $swm->marks[0]->unit_test + $swm->marks[0]->assessment + $swm->marks[0]->tutorial + $swm->marks[0]->attendance }}
                @if (isset($total[$swm->id]) && $total[$swm->id]<25)
                    <label class="label label-danger pull-right">NQ</label>
                @endif
            </td>
            @if ($swm->marks->isEmpty())
                {{ Form::hidden('mark['.$swm->id.'][student_id]',$swm->id) }}
                {{ Form::hidden('mark['.$swm->id.'][class_detail_id]',$class_detail->id) }}
                {{ Form::hidden('mark['.$swm->id.'][subject_id]',$subject->id) }}
                {{ Form::hidden('mark['.$swm->id.'][teacher_id]',Session::get('teacher')->id) }}
            @else
                {{ Form::hidden('mark['.$swm->id.'][id]',$swm->marks[0]->id) }}
            @endif
        </tr>
        @endforeach

    </table>

    <a href="{{ route('marks.export',[$class_detail->id, $subject->id]) }}" data-method="post" data-token="{{ Session::getToken() }}" class="btn btn-primary"><i class="glyphicon glyphicon-export"></i> Export</a>
    {{ Form::submit('Update Marks', ['class' => 'pull-right btn btn-info']) }}
    {{ Form::close() }}
    @else
    {{ Form::open(['route' => 'marks.store', 'method' => 'post']) }}
    <table class="table table-responsive table-bordered table-hover">
        <tr>
            <th>Name</th>
            <th>Roll No</th>
            <th>Unit Test (12)</th>
            <th>Assessment (24)</th>
            <th>Tutorial (10)</th>
            <th>Attendance (4)</th>
            <th>Total (50)</th>
        </tr>

        @foreach ($studentsWithMarks as $swm)
        <tr>
            <td>{{ ucfirst($swm->first_name) }} {{ ucfirst($swm->last_name) }}</td>
            <td>{{ $swm->roll_no }}</td>
            <td>{{ Form::text('mark['.$swm->id.'][unit_test]','0', ['class' => 'form-control','size'=>2,'data-validation'=>'number','data-validation-allowing'=>'float,range[0;12]','data-validation-error-msg'=>'Number between 0 & 12']) }}</td>
            <td>{{ Form::text('mark['.$swm->id.'][assessment]','0', ['class' => 'form-control','size'=>2,'data-validation'=>'number','data-validation-allowing'=>'float,range[0;24]','data-validation-error-msg'=>'Number between 0 & 24']) }}</td>
            <td>{{ Form::text('mark['.$swm->id.'][tutorial]','0', ['class' => 'form-control','size'=>2,'data-validation'=>'number','data-validation-allowing'=>'float,range[0;10]','data-validation-error-msg'=>'Number between 0 & 10']) }}</td>
            <td>{{ Form::text('mark['.$swm->id.'][attendance]','0', ['class' => 'form-control','size'=>2,'data-validation'=>'number','data-validation-allowing'=>'float,range[0;4]','data-validation-error-msg'=>'Number between 0 & 4']) }}</td>
            <td>0</td>
            {{ Form::hidden('mark['.$swm->id.'][student_id]',$swm->id) }}
            {{ Form::hidden('mark['.$swm->id.'][class_detail_id]',$class_detail->id) }}
            {{ Form::hidden('mark['.$swm->id.'][subject_id]',$subject->id) }}
            {{ Form::hidden('mark['.$swm->id.'][teacher_id]',Session::get('teacher')->id) }}
        </tr>
        @endforeach

    </table>

    {{ Form::submit('Add Marks', ['class' => 'pull-right btn btn-info']) }}
    {{ Form::close() }}
    @endif
@else
    <div class="col-md-3 col-md-offset-5 alert alert-warning">No students are assigned to this class.</div>
@endif
@stop