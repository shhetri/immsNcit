@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Teachers Assigned
@stop

@section('content')
    <div data-ng-controller="SubjectAssignedToController" data-ng-model="id" data-ng-init="id='{{ $subject->id }}'">
        <div data-ng-if="main.info.length!=0">
            <div>
                <label class="alert alert-info" style="padding: 5px">{{ Str::upper($subject->subject_name) }} is assigned to following teachers</label>
                <span class="text-muted col-xs-offset-1">Total assigns : <span class="badge">@{{ main.total }} </span></span>
                <div class="input-group col-xs-4 pull-right">
                    <input type="search" data-ng-model="searchInfo" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button data-ng-click="searchInfo = undefined" class="btn btn-default">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                     </span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <tr>
                        <th>SN</th>
                        <th>Teacher Name</th>
                        <th>Class</th>
                        <th>Batch</th>
                        <th class="text-center">Dissociate</th>
                    </tr>
                    <tr data-ng-repeat="info in main.info | filter:searchInfo">
                        <td>@{{ $index+1 }}</td>
                        <td>
                            <a data-ng-href="/teachers/@{{ info.pivot.teacher_id }}">@{{ info.first_name | capitalize }} @{{ info.last_name | capitalize }}</a>
                        </td>
                        <td>@{{ info.title }}</td>
                        <td>@{{ info.batch }}</td>
                        <td class="text-center">
                            <a data-ng-href="/teachers/@{{ info.pivot.teacher_id }}/subjects?batch=@{{ info.batch }}"><i class="glyphicon glyphicon-remove"></i></a>
                        </td>
                    </tr>
                </table>
            </div>
            <ul class="pager" data-ng-hide="main.pages == 1">
                <li><a data-ng-click='previousPage(this)'>Previous</a></li>
                <li><a data-ng-click='nextPage(this)'>Next</a></li>
            </ul>
        </div>
        <div data-ng-if="main.info.length==0">
            <p class="alert alert-info">{{ Str::upper($subject->subject_name) }} is not assigned to any teacher. <strong><a href="{{ route('teachers.index') }}">Assign</a></strong> to a teacher.</p>
        </div>
    </div>
@stop