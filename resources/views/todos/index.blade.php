@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Todos</h2>
            </div>
            <div class="pull-right">
                @can('todo-create')
                <a class="btn btn-success" href="{{ route('todos.create') }}"> Create New Todo</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($todos as $todo)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $todo->name }}</td>
	        <td>{{ $todo->detail }}</td>
	        <td>
                <form action="{{ route('todos.destroy',$todo->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('todos.show',$todo->id) }}">Show</a>
                    @can('todo-edit')
                    <a class="btn btn-primary" href="{{ route('todos.edit',$todo->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('todo-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $todos->links() !!}


@endsection