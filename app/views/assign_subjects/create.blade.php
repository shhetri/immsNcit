@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Assign Subject
@stop

@section('content')
    <div class="row well">
        <div>
            <label class="alert alert-success">Assign to {{ ucfirst($teacher->first_name) }} {{ ucfirst($teacher->last_name) }}</label>
        </div>
        <div class="col-md-5">
            {{ Form::open(['route' => ['teachers.subjects.store',$teacher->id], 'method' => 'post']) }}
            	<div class="form-group">
                    {{ Form::label('subject_id', 'Subject', ['class' => 'control-label']) }}
                    {{ Form::select('subject_id', $subjects , null , ['class' => 'form-control chosen-select']) }}
            	</div>
                <div class="form-group">
                    {{ Form::label('class_detail_id', 'Class', ['class' => 'control-label']) }}
                    {{ Form::select('class_detail_id', $classes , null , ['class' => 'form-control chosen-select']) }}
                </div>
                <div class="form-group">
                    {{ Form::submit('Assign', ['class' => 'btn btn-primary']) }}
                    {{ link_to_route('teachers.subjects.index','Cancel',$teacher->id,['class'=>'btn btn-warning']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop