@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Users
@stop

{{-- Content --}}
@section('content')
<h4>Current Users:</h4>
<div class="row">
  <div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>User</th>
				<th>Status</th>
				<th>Options</th>
                <th></th>
                <th></th>
			</thead>
			<tbody>
				@foreach ($users as $user)
					<tr>
						<td><a href="{{ action('Sentinel\UserController@show', array($user->id)) }}">@if($user->first_name && $user->last_name) {{$user->first_name}} {{$user->last_name}} @else {{$user->email}} @endif</a></td>
						<td>{{ $user->status }}</td>
						<td>
							<button class="btn btn-primary" type="button" onClick="location.href='{{ action('Sentinel\UserController@edit', array($user->id)) }}'">Edit</button>
                        </td>
                        <td>
							@if ($user->status != 'Banned')
								<button class="btn btn-warning {{ ($user->hasAccess('super admin'))? 'disabled' : '' }}" type="button" onClick="location.href='{{ action('Sentinel\UserController@ban', array($user->id)) }}'">Ban</button>
							@else
								<button class="btn btn-success" type="button" onClick="location.href='{{ action('Sentinel\UserController@unban', array($user->id)) }}'">Un-Ban</button>
							@endif
						</td>
                        <td>
							<button class="btn btn-danger action_confirm {{ ($user->hasAccess('super admin'))? 'disabled' : '' }}" href="{{ action('Sentinel\UserController@destroy', array($user->id)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button>
                        </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
  </div>
</div>
@stop
