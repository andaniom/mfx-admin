@extends('layouts.app')

@section('title', 'User')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Users"}}</h6>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEventModal">{{'Add User'}}</button>
            <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEventModal">Add Event</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="nameInput">Name</label>
                                    <input name="name" type="text" class="form-control" id="nameInput" aria-describedby="nameHelp" placeholder="Enter Name Event" required>
                                </div>
                                <div class="form-group">
                                    <label for="dateInput">Date</label>
                                    <input name="date" type="datetime-local" class="form-control" id="dateInput" placeholder="Enter Date Event" required>
                                </div>
                                <div class="form-group">
                                    <label for="descInput">Description</label>
                                    <input name="description" type="text" class="form-control" id="descInput" placeholder="Description" required>
                                </div>
                                <div class="form-group">
                                    <label for="photoInput">Photo</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Upload Photo</span>
                                        </div>
                                        <div class="custom-file">
                                            <input name="photo" type="file" class="custom-file-input" id="photoInput" accept="image/*"  required>
                                            <label class="custom-file-label" for="photoInput">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                    </thead>
                    @foreach($users as $user)
                        <tbody>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        </tbody>
                    @endforeach
                </table>
                <div class="d-flex">
                    <br/>
                    Halaman : {{ $users->currentPage() }} <br/>
                    Jumlah Data : {{ $users->total() }} <br/>
                    Data Per Halaman : {{ $users->perPage() }} <br/>
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
