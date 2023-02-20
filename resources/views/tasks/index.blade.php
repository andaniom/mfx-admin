@extends('layouts.app')

@section('title', 'Task')

@section('content')
    {{ Breadcrumbs::render('tasks') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Task List"}}</h6>
            <a type="button" class="btn btn-primary" href={{ route('tasks.create', '') }}>{{'Add Task'}}</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Task</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @foreach($tasks as $task)
                        <tbody>
                        <th>{{ $task->name }}</th>
                        <td>{{ $task->created_at }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            <div class="col">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%;" aria-valuemax="100">{{ $task->progress }}%
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <li class="d-block"><a href={{ route('tasks.show', $task->id) }} ><i>Detail</i></a></li>
                            <li class="d-block"><a href={{ route('tasks.edit', $task->id) }} ><i>Update</i></a></li>
                            @if($task->status === 'In Progress')
                                <li class="d-block"><a id="updateProgress" data-value="{{$task->progress}}"
                                                       href=#modalUpdateProgress data-toggle="modal"
                                                       data-target="#modalUpdateProgress"><i>Update Progress</i></a>
                                </li>
                                <div class="modal fade" id="modalUpdateProgress" tabindex="-1" role="dialog"
                                     aria-labelledby="modalUpdateProgressTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Update Task</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="slider">Progress</label>
                                                    <div id="slider">
                                                        <div id="custom-handle" class="ui-slider-handle"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    @include('components.upload.upload-image',['label'=>'Attachment', 'multiple'=>true])
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                        </tbody>
                    @endforeach
                </table>
                {{ $tasks->links('components.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
