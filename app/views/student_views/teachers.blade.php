@extends('layout.student.default_template')

@section('title')
@parent
Teachers
@stop

@section('content')
<div data-ng-controller="ViewController">
    <div data-ng-if="main.teachers.length!=0">
        <div class="col-xs-4">
            <div class="text-muted text-center form-group">Total teachers : <span
                    class="badge">@{{ main.total }} </span></div>
            <div class="form-group">
                <div class="input-group col-xs-12">
                    <input type="search" data-ng-model="searchTeacher" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button data-ng-click="searchTeacher = undefined" class="btn btn-default">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                     </span>
                </div>
            </div>
            <div class="list-group">
                <a href="" class="list-group-item" data-ng-repeat="teacher in main.teachers | filter:searchTeacher"
                   data-ng-class="{active : activeValue === teacher.id}" data-ng-click="getDetail(teacher.id)">
                    @{{ teacher.first_name|capitalize }} @{{ teacher.last_name|capitalize }}
                </a>
            </div>
            <ul class="pager" data-ng-hide="main.pages == 1">
                <li><a data-ng-click='previousPage(this)'>Previous</a></li>
                <li><a data-ng-click='nextPage(this)'>Next</a></li>
            </ul>
        </div>
        <div my-loading-spinner="viewLoading">
            <div data-ng-if="main.teacherDetail">
                <div class="well well-lg col-xs-6 col-xs-offset-1">
                    <h3 class="text-primary">Details</h3>
                    <table class="table">
                        <tr>
                            <th width="150">First Name</th>
                            <td width="50">:</td>
                            <td>@{{ main.teacherDetail.first_name|capitalize }}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>:</td>
                            <td>@{{ main.teacherDetail.last_name|capitalize }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>:</td>
                            <td>@{{ main.teacherDetail.email }}</td>
                        </tr>
                        <tr>
                            <th>Phone no</th>
                            <td>:</td>
                            <td>@{{ main.teacherDetail.phone_no }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div data-ng-if="main.teachers.length==0">
        <p class="alert alert-info">There are no teachers to display.</p>
    </div>
</div>
@stop