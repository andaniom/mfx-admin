@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    {{ Breadcrumbs::render('roles') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Roles"}}</h6>
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right">Add Roles</a>
        </div>
        <div class="card-body">
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Name</th>
                        <th width="3%" colspan="3">Action</th>
                    </tr>
                    </thead>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}">Show</a>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                            </td>
                            <td>
{{--                                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}--}}
{{--                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}--}}
{{--                                {!! Form::close() !!}--}}
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $roles->links('components.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
