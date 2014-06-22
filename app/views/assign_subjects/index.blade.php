@extends(Config::get('Sentinel::config.layout'))

@section('title')
    @parent
    Assigned Subjects
@stop

@section('content')
    @if (empty($batches))
        <div>
            <p class="alert alert-info">
                There are no subjects assigned to {{ ucfirst($teacher->first_name) }} {{ ucfirst($teacher->last_name) }}. Please <strong><a href="{{ route('teachers.subjects.create',$teacher->id) }}">Assign</a></strong> a new subject
            </p>
        </div>
    @else
        <div class="form-group">
            <a href="{{ route('teachers.subjects.create',$teacher->id) }}" class="btn btn-primary">Assign new</a>
            <label class="alert alert-info pull-right" style="padding: 5px;">{{ ucfirst($teacher->first_name) }} {{ ucfirst($teacher->last_name) }}</label>
        </div>
        <aside class="col-md-2">
           <div class="panel panel-default">
               <div class="panel-heading">Batch</div>
               <div class="list-group">
               @foreach ($batches as $batch)
                   <a href="{{ route('teachers.subjects.index',[$teacher->id,'batch='.$batch]) }}" class="list-group-item {{ (Input::get('batch')==$batch)?'active':'' }}">{{ $batch }}</a>
               @endforeach
            </div>
           </div>
        </aside>
        <section class="col-md-10">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th class="text-center">Dissociate</th>
                    </tr>
                    @if ( isset($subjectsWithClass) && ! $subjectsWithClass->isEmpty())
                        @foreach ($subjectsWithClass as $sc)
                    <tr>
                            <td><a href="{{ route('subjects.show',$sc->subject_id) }}">{{ Str::upper($sc->subject_name) }}</a></td>
                            <td><a href="{{ route('classes.show',$sc->class_detail_id) }}">{{ $sc->title }}</a></td>
                            <td class="text-center"><a href="{{ route('teachers.subjects.destroy',[$teacher->id,$sc->subject_id,'cdi='.$sc->class_detail_id]) }}" data-method="delete" data-token="{{ Session::getToken() }}" class="action_confirm"><i class="glyphicon glyphicon-remove-circle"></i></a></td>
                    </tr>
                    @endforeach
                    </table>
                    @else
                        </table>
                      <p class="alert alert-success col-md-3"> Please select the batch</p>
                    @endif
                </div>
        </section>
    @endif
@stop