@extends('layout.teacher.default_template')

@section('title')
    @parent
    Profile
@stop

@section('content')
<div class="well col-md-8 col-md-offset-2">
    <h4 class="text-info form-group">Profile <small><a href="{{ route('profiles.edit') }}">(Edit)</a></small><small class="pull-right"><a href="{{ route('users.edit',Session::get('userId')) }}">Change password</a></small></h4>
        <table class="table">
            <tr>
                <th width="150">First Name</th>
                <td width="50">:</td>
                <td>{{ $teacher->first_name }}</td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>:</td>
                <td>{{ $teacher->last_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>:</td>
                <td>{{ $teacher->email }}</td>
            </tr>
            <tr>
                <th>Phone no</th>
                <td>:</td>
                <td>{{ $teacher->phone_no }}</td>
            </tr>
        </table>
</div>
@stop