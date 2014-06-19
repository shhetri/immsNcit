@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Teachers
@stop
@section('content')
    <div data-ng-controller="TeacherController" data-ng-init="loadPage()">
        <div data-ng-if="main.teachers.length!=0">
        <div class="form-group">
            <a href="{{ route('teachers.create') }}" class="btn btn-primary">Add New</a>
            <span class="text-muted col-xs-offset-3">Total teachers : <span class="badge">@{{ main.total }} </span></span>
            <div class="input-group col-xs-4 pull-right">
                <input type="search" data-ng-model="searchTeacher" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button data-ng-click="searchTeacher = undefined" class="btn btn-default">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                 </span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th>S.N</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Status</th>
                    <th>Edit</th>
                </tr>
                <tr data-ng-repeat="teacher in main.teachers | filter:searchTeacher">
                    <td>@{{ $index+1 }}</td>
                    <td>
                        <a data-ng-href="/teachers/@{{ teacher.id }}">@{{ teacher.first_name | capitalize }}</a>
                    </td>
                    <td>@{{ teacher.last_name | capitalize }}</td>
                    <td>@{{ teacher.status }}</td>
                    <td><a data-ng-href="/teachers/@{{ teacher.id }}/edit"><span><i class="glyphicon glyphicon-edit"></i></span></a></td>
                </tr>
            </table>
        </div>
            <ul class="pager" data-ng-hide="main.pages == 1">
                <li><a data-ng-click='previousPage(this)'>Previous</a></li>
                <li><a data-ng-click='nextPage(this)'>Next</a></li>
            </ul>
        </div>
        <div data-ng-if="main.teachers.length==0">
            <p class="alert alert-info">There are no teachers to display. Please <strong><a href="{{ route('teachers.create') }}">Add</a></strong> a new teacher</p>
        </div>
    </div>
@stop