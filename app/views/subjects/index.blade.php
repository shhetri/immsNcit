@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Subjects
@stop

@section('content')
<div data-ng-controller="SubjectController">
    <div data-ng-if="main.subjects.length!=0">
        <div class="form-group">
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">Add New</a>
            <span class="text-muted col-xs-offset-3">Total subjects : <span class="badge">@{{ main.total }} </span></span>
            <div class="input-group col-xs-4 pull-right">
                <input type="search" data-ng-model="searchSubject" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button data-ng-click="searchSubject = undefined" class="btn btn-default">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                 </span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th>SN</th>
                    <th>Subject Name</th>
                    <th>Course Code</th>
                    <th>Edit</th>
                    <th class="text-center">Assigned To</th>
                </tr>
                <tr data-ng-repeat="subject in main.subjects | filter:searchSubject">
                    <td>@{{ $index+1 }}</td>
                    <td>
                        <a data-ng-href="/subjects/@{{ subject.id }}">@{{ subject.subject_name | uppercase }}</a>
                    </td>
                    <td>@{{ subject.course_code | uppercase }}</td>
                    <td><a data-ng-href="/subjects/@{{ subject.id }}/edit"><span><i class="glyphicon glyphicon-edit"></i></span></a></td>
                    <td class="text-center"><a data-ng-href="/subjects/@{{ subject.id }}/teachers"><span><i class="glyphicon glyphicon-tasks"></i></span></a></td>
                </tr>
            </table>
        </div>
        <ul class="pager" data-ng-hide="main.pages == 1">
            <li><a data-ng-click='previousPage(this)'>Previous</a></li>
            <li><a data-ng-click='nextPage(this)'>Next</a></li>
        </ul>
    </div>
    <div data-ng-if="main.subjects.length==0">
        <p class="alert alert-info">There are no subjects to display. Please <strong><a href="{{ route('subjects.create') }}">Add</a></strong> a new subject</p>
    </div>
</div>
@stop