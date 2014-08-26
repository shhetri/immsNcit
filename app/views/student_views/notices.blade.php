@extends('layout.student.default_template')

@section('title')
    @parent
    Notices
@stop

@section('content')
<div class="well col-md-8 col-md-offset-2">
    @if ($notices->isEmpty())
    <label class="alert alert-link">There are no notices to display.</label>
    @else
    @if ($notices->getTotal()>10)
    {{ $notices->links() }}
    @endif

    @foreach ($notices as $notice)
    <div class="panel panel-default">
        <div class="panel-body">
            <h4 class="text-primary">{{ $notice->title }}</h4>
            <div class="help-block">Date : {{ $notice->updated_at->format('F j, Y, g:i a') }} <label class="pull-right">Posted By : {{ ucfirst($notice->teachers->first_name) }} {{ ucfirst($notice->teachers->last_name) }}</label></div>
            <div>{{ $notice->body }}</div>
        </div>
    </div>
    @endforeach

    @endif
</div>
@stop