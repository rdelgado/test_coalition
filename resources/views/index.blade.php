@extends('layout')

@section('main-content')
    <div>
        <div class="float-start">
            <h4 class="pb-3">My Tasks</h4>
        </div>
        <div class="float-end">
        <form action="{{ route('task.index') }}" method="GET" id="frmSearch">
            Search by project
                <select name="project" id="project" class="form-control" onchange="document.getElementById('frmSearch').submit()">
                    <option value="">Select option</option>
                    <option value="ALL">ALL</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project['value'] }}">{{ $project['label'] }}</option>
                    @endforeach
                </select>
        </form>
            <a href="{{ route('task.create') }}" class="btn btn-info">
               <i class="fa fa-plus-circle"></i> Create Task
            </a>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="sort_menu list-group">
    @foreach ($tasks as $task)
        <div class="card mt-3 list-group-item"  data-id="{{$task->id}}">
            <h5 class="card-header handle">
              
                    {{ $task->name }}
              

                <span class="badge rounded-pill bg-warning text-dark">
                    Created: {{ $task->created_at->diffForHumans() }}
                </span>
            </h5>

            <div class="card-body">
                <div class="card-text">
                    <div class="float-start">
                

                            <span class="badge rounded-pill bg-info text-dark">
                            Priority: {{ $task->priority }}
                            </span>
                           <br />

                           <span class="badge rounded-pill bg-danger text-dark">
                            Project: {{ $task->project }}
                            </span>
                           <br />


                        <small>Last Updated - {{ $task->updated_at->diffForHumans() }} </small>
                    </div>
                    <div class="float-end">
                        <a href="{{ route('task.edit', $task->id) }}" class="btn btn-success">
                           <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('task.destroy', $task->id) }}" style="display: inline" method="POST" onsubmit="return confirm('Are you sure to delete ?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @endforeach
    </div>

    @if (count($tasks) === 0)
        <div class="alert alert-danger p-2">
            No Task Found. Please Create one task
            <br>
            <br>
            <a href="{{ route('task.create') }}" class="btn btn-info">
                <i class="fa fa-plus-circle"></i> Create Task
             </a>
        </div>
    @endif

    <script>
    $(document).ready(function(){

    	function updateToDatabase(idString){
    	   $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});
    		
    	   $.ajax({
              url:'{{url('/task/update-order')}}',
              method:'POST',
              data:{ids:idString},
              success:function(){
                 alert('Successfully updated')
               	 location.reload();
              }
           })
    	}

        var target = $('.sort_menu');
        target.sortable({
            handle: '.handle',
            placeholder: 'highlight',
            axis: "y",
            update: function (e, ui){
               var sortData = target.sortable('toArray',{ attribute: 'data-id'})
               updateToDatabase(sortData.join(','))
            }
        })
        
    })
</script>

<style>
    .list-group-item {
        display: flex;
        align-items: center;
    }

    .highlight {
        background: #f7e7d3;
        list-style-type: none;
    }

    .handle {
        width: 100%;
        background: #607D8B;
        display: inline-block;
        cursor: move;

    }
</style>
@endsection
