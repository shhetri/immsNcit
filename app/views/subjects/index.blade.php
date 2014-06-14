@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Subjects
@stop
@section('content')
@if( ! $allSubjects->isEmpty())
<div class="form-group">
    <a href="{{ route('subjects.create') }}" class="btn btn-primary">Add New</a>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th>SN</th>
            <th>Subject Name</th>
            <th>Course Code</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        @foreach ($allSubjects as $subject)
        <tr>
            <td>
                {{ isset($count)? ++$count:$count=$allSubjects->getCurrentPage()*10-9 }}
            </td>
            <td>
                {{ Str::upper($subject->subject_name) }}
            </td>
            <td>
                {{ Str::upper($subject->course_code) }}
            </td>
            <td>
                <a href="{{ route('subjects.edit',$subject->id) }}"><span><i class="glyphicon glyphicon-edit"></i></span></a>
            </td>
            <td>
                <a href="{{route('subjects.destroy',$subject->id) }}" data-method="delete" data-token="{{ Session::getToken() }}" class="action_confirm"><span><i class="glyphicon glyphicon-trash"></i></span></a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
{{ $allSubjects->links(); }}
@else
<p class="alert alert-info">There are no subjects to display. Please <strong><a href="{{ route('subjects.create') }}">Add</a></strong> a new subject</p>
@endif
@stop