@extends('layouts.app')

@section('title', 'Task')

@section('content')
    {{ Breadcrumbs::render('task-create') }}
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nameInput">Task Description</label>
            <textarea name="task" class="form-control" id="taskInput" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
