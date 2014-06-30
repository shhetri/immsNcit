@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Students
@stop
@section('content')
<div data-ng-controller="StudentController">
    <div class=" row well">
        <div>
            <label class="alert alert-info" style="padding: 5px">Select Faculty, Shift and Batch</label>
            <a href="{{ route('students.create','file=true') }}" class="btn btn-primary pull-right" style="margin-left: 6px;">Add from Excel file</a>
            <a href="{{ route('students.create') }}" class="btn btn-primary pull-right">Add New</a>
        </div>
            <div class="col-md-6 form-group">
                {{ Form::label('faculty', 'Faculty', ['class'=>'control-label']) }}
                <ui-select ng-model="faculty.selected" theme="bootstrap">
                    <ui-select-match placeholder="Select faculty...">@{{$select.selected.faculty_name + ' : '+$select.selected.faculty_description}}</ui-select-match>
                    <ui-select-choices repeat="faculty in info.faculty | filter: $select.search">
                        <div ng-bind-html="faculty.faculty_name +' : '+ faculty.faculty_description | highlight: $select.search"></div>
                    </ui-select-choices>
                </ui-select>
            </div>
            <div class="col-md-3 form-group">
                {{ Form::label('shift', 'Shift', ['class'=>'control-label']) }}
                <ui-select ng-model="shift.selected" theme="bootstrap">
                    <ui-select-match placeholder="Select shift...">@{{$select.selected.shift}}</ui-select-match>
                    <ui-select-choices repeat="shift in info.shift | filter: $select.search">
                        <div ng-bind-html="shift.shift | highlight: $select.search"></div>
                    </ui-select-choices>
                </ui-select>
            </div>
            <div class="col-md-3 form-group">
                {{ Form::label('batch', 'Batch', ['class'=>'control-label']) }}
                <ui-select ng-model="batch.selected" theme="bootstrap">
                    <ui-select-match placeholder="Select batch...">@{{$select.selected.batch}}</ui-select-match>
                    <ui-select-choices repeat="batch in info.batch | filter: $select.search">
                        <div ng-bind-html="batch.batch | highlight: $select.search"></div>
                    </ui-select-choices>
                </ui-select>
            </div>
            <div class="col-md-3 form-group">
                <button class="btn btn-primary" data-ng-click="getStudents()">View</button>
            </div>
        </div>
    <div my-loading-spinner="viewLoading">
    <div data-ng-if="main.students.length!=0">
        <span class="text-muted">Total Students : <span class="badge">@{{ main.students.length }} </span></span>
        <span class="form-group input-group col-xs-4 pull-right">
            <input type="search" data-ng-model="searchStudent" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button data-ng-click="searchStudent = undefined" class="btn btn-default">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </span>
        </span>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Roll No.</th>
                    <th>Batch</th>
                    <th>Faculty</th>
                    <th>Shift</th>
                    <th>Edit</th>
                </tr>
                <tr data-ng-repeat="student in main.students | filter:searchStudent">
                    <td>@{{ $index+1 }}</td>
                    <td>
                        <a data-ng-href="/students/@{{ student.id }}">@{{ student.first_name | capitalize }} @{{ student.last_name | capitalize }}</a>
                    </td>
                    <td>@{{ student.roll_no }}</td>
                    <td>@{{ student.batch }}</td>
                    <td>@{{ student.faculty.faculty_name }}</td>
                    <td>@{{ student.shift.shift }}</td>
                    <td><a data-ng-href="/students/@{{ student.id }}/edit"><span><i class="glyphicon glyphicon-edit"></i></span></a></td>
                </tr>
            </table>
        </div>
    </div>
    <div data-ng-show="main.noStudents">
        <p class="alert alert-info">There are no students to display. Please <strong><a href="{{ route('students.create') }}">Add</a></strong> a new student</p>
    </div>
    </div>
</div>
@stop