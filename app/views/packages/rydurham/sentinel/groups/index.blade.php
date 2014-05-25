@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Groups
@stop

{{-- Content --}}
@section('content')
<h4>Available Groups</h4>
<div class="row">
  <div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>Name</th>
				<th>Permissions</th>
				<th>Options</th>
                <th></th>
			</thead>
			<tbody>
			@foreach ($groups as $group)
				<tr>
					<td><a href="groups/{{ $group->id }}">{{ $group->name }}</a></td>
					<td>{{ (isset($group['permissions']['super admin'])) ? '<i class="icon-ok"></i> Super Admin,' : ''}} {{ (isset($group['permissions']['admin'])) ? '<i class="icon-ok"></i> Admin,' : ''}} {{ (isset($group['permissions']['users'])) ? '<i class="icon-ok"></i> Users' : ''}}</td>
					<td>
						<button class="btn btn-primary {{ (isset($group['permissions']['super admin'])) ? 'disabled' : '' }}" onClick="location.href='{{ action('Sentinel\GroupController@edit', array($group->id)) }}'">Edit</button>
                    </td>
                    <td>
					 	<button class="btn btn-danger action_confirm {{ (isset($group['permissions']['super admin'])) ? 'disabled' : '' }}" type="button" data-token="{{ Session::getToken() }}" data-method="delete" href="{{ URL::action('Sentinel\GroupController@destroy', array($group->id)) }}">Delete</button>
					 </td>
				</tr>	
			@endforeach
			</tbody>
		</table> 
	</div>
	 <button class="btn btn-primary" onClick="location.href='{{ URL::action('Sentinel\GroupController@create') }}'">New Group</button>
   </div>
</div>
<!--  
	The delete button uses Resftulizer.js to restfully submit with "Delete".  The "action_confirm" class triggers an optional confirm dialog.
	Also, I have hardcoded adding the "disabled" class to the Admin group - deleting your own admin access causes problems.
-->
@stop

