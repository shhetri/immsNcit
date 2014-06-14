@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Teachers
@stop
@section('content')
@if( ! $allTeachers->isEmpty())
<div class="form-group">
    <a href="{{ route('teachers.create') }}" class="btn btn-primary">Add New</a>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th>SN</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone No.</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        @foreach ($allTeachers as $teacher)
        <tr>
            <td>
                {{ isset($count)? ++$count:$count=$allTeachers->getCurrentPage()*10-9 }}
            </td>
            <td>
                {{ ucfirst($teacher->first_name) }}
            </td>
            <td>
                {{ ucfirst($teacher->last_name) }}
            </td>
            <td>
                {{ $teacher->email }}
            </td>
            <td>
                {{ $teacher->phone_no }}
            </td>
            <td>
                {{ ($teacher->status==1)?'Active':'Inactive' }}
            </td>
            <td>
                <a href="{{ route('teachers.edit',$teacher->id) }}"><span><i class="glyphicon glyphicon-edit"></i></span></a>
            </td>
            <td>
                <a href="{{route('teachers.destroy',$teacher->id) }}" data-method="delete" data-token="{{ Session::getToken() }}" class="action_confirm"><span><i class="glyphicon glyphicon-trash"></i></span></a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
{{ $allTeachers->links(); }}
@else
<p class="alert alert-info">There are no teachers to display. Please <strong><a href="{{ route('teachers.create') }}">Add</a></strong> a new teacher</p>
@endif
@stop