@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    View Teacher
@stop

@section('content')

    <label class="alert alert-info">{{ ucfirst($teacher->first_name) }} {{ ucfirst($teacher->last_name) }}'s Profile</label>
    {{ link_to_route('teachers.index','Return to Index',null,['class'=>'btn btn-info pull-right']) }}
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>{{ ucfirst($teacher->first_name) }}</td>
                <td>{{ ucfirst($teacher->last_name) }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->phone_no }}</td>
                <td>{{ ($teacher->status==1)?'Active':'Inactive' }}</td>
                <td>{{ link_to_route('teachers.edit','Edit',$teacher->id,['class'=>'btn btn-primary']) }}</td>
                <td><a href="{{route('teachers.destroy',$teacher->id) }}" data-method="delete" data-token="{{ Session::getToken() }}" class="action_confirm btn btn-danger">Delete</a></td>
            </tr>
        </table>
    </div>
@stop