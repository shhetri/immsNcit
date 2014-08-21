@extends('layout.teacher.default_template')

@section('title')
    @parent
    Subjects
@stop

@section('content')
    <table class="table table-responsive table-bordered table-hover">
        <tr>
            <th>Class</th>
            <th>Subject</th>
        </tr>
        @foreach ($subjectsWithClass as $swc)
        <tr>
            <td>{{ $swc->title }}</td>
            <td><a href="{{ route('subject.marks',[$swc->pivot->class_detail_id, $swc->pivot->subject_id]) }}">{{ Str::upper($swc->subject_name) }}</a></td>
        </tr>
        @endforeach
    </table>

@stop