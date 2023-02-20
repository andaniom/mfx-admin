@extends('layouts.app')

@section('title', 'User')

@section('content')
    {{ Breadcrumbs::render('users') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Users"}}</h6>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">Create User</a>
        </div>
        <div class="card-body">
            <form action="{{ route('users.index') }}" method="GET">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Filter</span>
                    </div>
                    <input type="text" class="form-control" name="filter" value="{{ request('filter') }}">
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                    <button type="button" class="btn btn-secondary ml-2"
                            onclick="window.location='{{ route('users.index') }}'">Clear
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @foreach($users as $user)
                        <tbody>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <li class="d-block"><a href={{route('users.show', $user->id)}}><i>Show</i></a>
                            <li class="d-block"><a href={{route('users.edit', $user->id)}}><i>Edit</i></a>
                            </li>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                                @if($user->status === 0)
                                    <li class="d-block"><a href={{route('users.update', [$user->id, 'status', 1])}}><i>Confirmation</i></a>
                                    </li>
                                @elseif($user->status === 2)
                                    <li class="d-block"><a
                                            href="{{route('users.update', [$user->id, 'status', 1])}}"><i>Active</i></a>
                                    </li>
                                @elseif($user->status === 1)
                                    <li class="d-block"><a
                                            href="{{route('users.update', [$user->id, 'status', 2])}}"><i>Inactive</i></a>
                                    </li>
                                @endif
                            @endif
                            @if(auth()->user()->hasRole('super_admin'))
                                @if($user->role === 'admin')
                                    <li class="d-block"><a
                                            href="{{route('users.update', [$user->id, 'role', 'users'])}}"><i>Remove
                                                from Admin</i></a></li>
                                @else
                                    <li class="d-block"><a
                                            href="{{route('users.update', [$user->id, 'role', 'admin'])}}"><i>Add
                                                to Admin</i></a></li>
                        @endif
                        @endif
                        </tbody>
                    @endforeach
                </table>
                {{ $users->appends(request()->input())->links('components.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
