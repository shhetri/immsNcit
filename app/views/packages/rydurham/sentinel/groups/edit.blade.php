@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
	{{ Form::open(array('action' =>  array('Sentinel\GroupController@update', $group->id), 'method' => 'put','class'=>'well well-lg')) }}
        <h4>Edit Group</h4>
    
        <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
            {{ Form::text('name', $group->name, array('class' => 'form-control', 'placeholder' => 'Name')) }}
            {{ ($errors->has('name') ? $errors->first('name') : '') }}
        </div>

        {{ Form::label('Permissions') }}
        <?php 
            $permissions = $group->getPermissions(); 
            if (!array_key_exists('super admin', $permissions)) $permissions['super admin'] = 0;
            if (!array_key_exists('admin', $permissions)) $permissions['admin'] = 0;
            if (!array_key_exists('users', $permissions)) $permissions['users'] = 0;
        ?>
        
        <div class="form-group">
            <label class="checkbox-inline">
                {{ Form::checkbox('superAdminPermissions', 1, $permissions['super admin'] ) }} Super Admin
            </label>
            <label class="checkbox-inline">
                {{ Form::checkbox('adminPermissions', 1, $permissions['admin'] ) }} Admin
            </label>
            <label class="checkbox-inline">
                {{ Form::checkbox('userPermissions', 1, $permissions['users'] ) }} Users
            </label>
        </div>

        {{ Form::hidden('id', $group->id) }}
        {{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
    </div>
</div>

@stop