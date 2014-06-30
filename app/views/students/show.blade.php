@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    View Student
@stop

@section('content')

<label class="alert alert-info">{{ ucfirst($student->first_name) }} {{ ucfirst($student->last_name) }}'s Info</label>
{{ link_to_route('students.index','Return to Index',null,['class'=>'btn btn-info pull-right']) }}
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Roll No.</th>
            <th>Batch</th>
            <th>Faculty</th>
            <th>Shift</th>
        </tr>
        <tr>
            <td>{{ ucfirst($student->first_name) }}</td>
            <td>{{ ucfirst($student->last_name) }}</td>
            <td>{{ $student->roll_no }}</td>
            <td>{{ $student->batch }}</td>
            <td>{{ $student->faculty->faculty_name }}</td>
            <td>{{ $student->shift->shift }}</td>
            <td>{{ link_to_route('students.edit','Edit',$student->id,['class'=>'btn btn-primary']) }}</td>
            <td><a href="{{route('students.destroy',$student->id) }}" data-method="delete" data-token="{{ Session::getToken() }}" class="action_confirm btn btn-danger">Delete</a></td>
        </tr>
    </table>
</div>
@stop