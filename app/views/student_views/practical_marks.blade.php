@extends('layout.student.default_template')

@section('title')
@parent
Marks
@stop

@section('content')
{{ Form::open(['route' => 'view.marks', 'method' => 'get', 'class' => 'form-inline']) }}
<div class="form-group">
    {{ Form::label('class', 'Class :', ['class' => 'control-label']) }}
    {{ Form::select('class_detail_id', $classes , $classDetail->id , ['class' => 'form-control chosen-select']) }}
</div>
<div class="form-group">
    {{ Form::label('subject', 'Subject :', ['class' => 'control-label']) }}
    {{ Form::select('subject_id', $subjects , $subject->id , ['class' => 'form-control chosen-select']) }}
</div>

{{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
<hr/>
<div class="alert alert-success text-center"><strong>Teacher :</strong> {{ ucfirst($teacherDetail->first_name) }} {{ ucfirst($teacherDetail->last_name) }}</div>
<div class="form-group">
    <label class="alert alert-info">{{ Str::upper($subject->subject_name) }}</label>
    <label class="alert alert-warning pull-right">{{ $classDetail->title }} ({{ $classDetail->batch }})</label>
</div>
<table id="data_table" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Name</th>
        <th>Roll No</th>
        <th>Unit Test (7)</th>
        <th>Assessment (14)</th>
        <th>Tutorial (6)</th>
        <th>Attendance (3)</th>
        <th>Theory (30)</th>
        <th>Practical (20)</th>
        <th>Total (50)</th>
        <th>Remark</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
@stop

@section('dataTable_script')
<script>
    var table = $('#data_table').dataTable({
        "bProcessing": true,
        "sAjaxSource": "{{ route('view.getMarks',[$classDetail->id, $subject->id]) }}",
        "sAjaxDataProp": '',
        "aoColumns": [
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    return full['first_name'] + '&nbsp;' + full['last_name'];
                }
            },
            { "mData": "roll_no" },
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    if (full.marks.length > 0) {
                        return full.marks[0].unit_test;
                    }
                    else {
                        return '-';
                    }
                }
            },
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    if (full.marks.length > 0) {
                        return full.marks[0].assessment;
                    }
                    else {
                        return '-';
                    }
                }
            },
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    if (full.marks.length > 0) {
                        return full.marks[0].tutorial;
                    }
                    else {
                        return '-';
                    }
                }
            },
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    if (full.marks.length > 0) {
                        return full.marks[0].attendance;
                    }
                    else {
                        return '-';
                    }
                }
            },
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    if (full.marks.length > 0) {
                        return Number(full.marks[0].unit_test) + Number(full.marks[0].assessment) + Number(full.marks[0].tutorial) + Number(full.marks[0].attendance);
                    }
                    else {
                        return '-';
                    }
                }
            },
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    if (full.marks.length > 0) {
                        return full.marks[0].practical;
                    }
                    else {
                        return '-';
                    }
                }
            },
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    if (full.marks.length > 0) {
                        return Number(full.marks[0].unit_test) + Number(full.marks[0].assessment) + Number(full.marks[0].tutorial) + Number(full.marks[0].attendance) + Number(full.marks[0].practical);
                    }
                    else {
                        return '-';
                    }
                }
            },
            {
                "mData": null,
                "mRender": function (data, type, full) {
                    if (full.marks.length > 0) {
                        if ((Number(full.marks[0].unit_test) + Number(full.marks[0].assessment) + Number(full.marks[0].tutorial) + Number(full.marks[0].attendance)) < 15 || Number(full.marks[0].practical) < 12) {
                            return '<label class="label label-danger pull-right">NQ</label>';
                        }
                        else {
                            return '';
                        }
                    }
                    else {
                        return '-';
                    }

                }
            }
        ]
    });
    $.fn.dataTable.TableTools.defaults.aButtons = [ "copy", "xls", "print" ];
    var tableTools = new $.fn.dataTable.TableTools( table );

    $( tableTools.fnContainer() ).insertBefore('#data_table');
</script>
@stop