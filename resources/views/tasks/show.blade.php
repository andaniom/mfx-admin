@extends('layouts.app')

@section('title', 'Task')

@section('content')
    {{ Breadcrumbs::render('tasks') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ $task->name }}</h6>
        </div>
        <div class="card-body">
            <p>Status: {{ $task->status }}</p>
            <p>Progress: {{ $task->progress }}%</p>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ 'Description' }}</h6>
        </div>
        <div class="card-body">
            {!! $task->description !!}
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ 'History' }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Old Status</th>
                        <th>New Status</th>
                        <th>Actor</th>
                    </tr>
                    </thead>
                    @foreach($taskHistories as $history)
                        <tbody>
                        <th>{{ $history->created_at }}</th>
                        <td>{{ $history->old_status }}</td>
                        <td>{{ $history->new_status }}</td>
                        <td>{{ $history->name }}</td>
                        </tbody>
                    @endforeach
                </table>
                {{ $taskHistories->links('components.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
