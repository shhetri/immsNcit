@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Classes
@stop

@section('content')
<div data-ng-controller="ClassController">
    <div data-ng-if="main.classes.length!=0">
        <div class="form-group">
            <a href="{{ route('classes.create') }}" class="btn btn-primary">Add New</a>
            <span class="text-muted col-xs-offset-3">Total classes : <span class="badge">@{{ main.total }} </span></span>
            <div class="input-group col-xs-4 pull-right">
                <input type="search" data-ng-model="searchClass" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button data-ng-click="searchClass = undefined" class="btn btn-default">
                         <span class="glyphicon glyphicon-trash"></span>
                    </button>
                 </span>
            </div>

        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th>SN</th>
                    <th>Faculty</th>
                    <th>Semester</th>
                    <th>Shift</th>
                    <th>Batch</th>
                    <th>Edit</th>
                </tr>
                <tr data-ng-repeat="class in main.classes | filter:searchClass">
                    <td>@{{ $index+1 }}</td>
                    <td>
                        <a data-ng-href="/classes/@{{ class.id }}">@{{ class.faculty.faculty_name }}</a>
                    </td>
                    <td>@{{ class.semester.semester_name }}</td>
                    <td>@{{ class.shift.shift }}</td>
                    <td>@{{ class.batch }}</td>
                    <td><a data-ng-href="/classes/@{{ class.id }}/edit"><span><i class="glyphicon glyphicon-edit"></i></span></a></td>
                </tr>
            </table>
        </div>
        <ul class="pager" data-ng-hide="main.pages == 1">
            <li><a data-ng-click='previousPage(this)'>Previous</a></li>
            <li><a data-ng-click='nextPage(this)'>Next</a></li>
        </ul>
    </div>
    <div data-ng-if="main.classes.length==0">
        <p class="alert alert-info">There are no classes to display. Please <strong><a href="{{ route('classes.create') }}">Add</a></strong> a new class</p>
    </div>
</div>
@stop