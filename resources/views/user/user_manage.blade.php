@extends('layouts.app')

@section('title', 'User')

@section('content')
    {{ Breadcrumbs::render('user') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Users"}}</h6>
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
        </div>
        <div class="card-body">
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
                        @if($user->role !== 'super_admins')
                            <tbody style="{{$user->status !== 1 ? 'background-color: yellow' : ''}}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
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
                                                href="{{route('users.update', [$user->id, 'role', 'user'])}}"><i>Remove
                                                    from Admin</i></a></li>
                                    @else
                                        <li class="d-block"><a
                                                href="{{route('users.update', [$user->id, 'role', 'admin'])}}"><i>Add
                                                    to Admin</i></a></li>
                                    @endif
                                @endif
                            </td>
                            </tbody>
                        @endif
                    @endforeach
                </table>
                {{ $users->links('components.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
