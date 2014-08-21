@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    View Subject
@stop

@section('content')

<label class="alert alert-info">{{ Str::title($subject->subject_name) }} Info</label>
{{ link_to_route('subjects.index','Return to Index',null,['class'=>'btn btn-info pull-right']) }}
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>Subject Name</th>
            <th>Course Code</th>
            <th>Type</th>
        </tr>
        <tr>
            <td>{{ Str::upper($subject->subject_name) }}</td>
            <td>{{ Str::upper($subject->course_code) }}</td>
            <td>{{ $subject->type }}</td>
            <td>{{ link_to_route('subjects.edit','Edit',$subject->id,['class'=>'btn btn-primary']) }}</td>
            <td><a href="{{route('subjects.destroy',$subject->id) }}" data-method="delete" data-token="{{ Session::getToken() }}" class="action_confirm btn btn-danger">Delete</a></td>
        </tr>
    </table>
</div>
@stop