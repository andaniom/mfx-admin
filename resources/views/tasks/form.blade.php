@extends('layouts.app')

@section('title', 'Task')

@section('content')
    {{ Breadcrumbs::render('tasks') }}
    <div class="card shadow mb-4">
        <div class="card-header ">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($task) ? 'Edit Task' : 'Create Task' }}</h6>
        </div>

        <div class="card-body">
            <form method="post" action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store') }}">
                @if(isset($task))
                    @method('PATCH')
                @endif
                @csrf
                <div class="form-group">
                    <label for="name">Task Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ isset($task) ? $task->name : '' }}" required>
                </div>
                <div class="form-group">
                    <label for="assignee">Assignee</label>
                    <select class="form-control" id="assignee" name="assignee_id">
                        @foreach ($assignees as $assignee)
                            <option
                                value="{{ $assignee->id }}" {{ (isset($task) && $task->assignee_id == $assignee->id) || (old('assignee_id') == $assignee->id) ? 'selected' : '' }}>{{ $assignee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="progress">Progress</label>
                    <input type="number" class="form-control" id="progress" name="progress"
                           value="{{ isset($task) ? $task->progress : 0 }}" min="0" max="100" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        @foreach ($statuses as $status)
                            <option
                                value="{{ $status }}" {{ (isset($task) && $task->status == $status) || (old('status') == $status) ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="percentage_progress">Description</label>
                    <textarea id="tinyMce" name="description">{{ isset($task) ? $task->description : '' }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($task) ? 'Update' : 'Create' }}</button>
            </form>
        </div>
    </div>
@endsection
