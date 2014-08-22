@extends('layout.teacher.default_template')

@section('title')
    @parent
    Notice
@stop

@section('content')
    <div class="well col-md-8 col-md-offset-2">
        @if ($notices->isEmpty())
            <label class="alert alert-link">There are no notices to display. <a href="{{ route('notices.create') }}"><strong>Add</strong></a> new notice.</label>
        @else
        <div class="form-group">
            <a href="{{ route('notices.create') }}" class="btn btn-primary">Add new</a>
        </div>
            @if ($notices->getTotal()>10)
            {{ $notices->links() }}
            @endif

            @foreach ($notices as $notice)
                <div class="panel panel-default">
                    <div class="form-group">
                        <a href="{{ route('notices.destroy',$notice->id) }}" data-method="delete" data-token="{{ Session::getToken() }}" class="action_confirm">
                            <i class="glyphicon glyphicon-remove-sign pull-right"></i>
                        </a>
                        <a href="{{ route('notices.edit',$notice->id) }}">
                             <i class="glyphicon glyphicon-edit pull-right" style="margin-right: 5px"></i>
                        </a>
                    </div>
                    <div class="panel-body">
                        <h4 class="text-primary">{{ $notice->title }}</h4>
                        <div class="help-block">Date : {{ $notice->updated_at->format('F j, Y, g:i a') }}</div>
                        <div>{{ $notice->body }}</div>
                    </div>
                </div>
            @endforeach

        @endif
    </div>
@stop