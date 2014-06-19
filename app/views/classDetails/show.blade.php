@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    View Class
@stop

@section('content')

<label class="alert alert-info">{{ $classDetail->title }} Info</label>
{{ link_to_route('classes.index','Return to Index',null,['class'=>'btn btn-info pull-right']) }}
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>Faculty</th>
            <th>Faculty Description</th>
            <th>Semester</th>
            <th>Shift</th>
            <th>Batch</th>
        </tr>
        <tr>
            <td>{{ $classDetail->faculty->faculty_name }}</td>
            <td>{{ $classDetail->faculty->faculty_description }}</td>
            <td>{{ $classDetail->semester->semester_name }}</td>
            <td>{{ $classDetail->shift->shift }}</td>
            <td>{{ $classDetail->batch }}</td>
            <td>{{ link_to_route('classes.edit','Edit',$classDetail->id,['class'=>'btn btn-primary']) }}</td>
            <td><a href="{{route('classes.destroy',$classDetail->id) }}" data-method="delete" data-token="{{ Session::getToken() }}" class="action_confirm btn btn-danger">Delete</a></td>
        </tr>
    </table>
</div>
@stop