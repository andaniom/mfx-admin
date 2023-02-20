@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    {{ Breadcrumbs::render('posts-create') }}
    <div class="bg-light p-4 rounded">
        <h1>{{ ucfirst($role->name) }} Role</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">

            <h3>Assigned permissions</h3>

            <table class="table table-striped">
                <thead>
                <th scope="col" width="20%">Name</th>
                <th scope="col" width="1%">Guard</th>
                </thead>

                @foreach($rolePermissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('[name="all_permission"]').on('click', function () {

                if ($(this).is(':checked')) {
                    $.each($('.permission'), function () {
                        $(this).prop('checked', true);
                    });
                } else {
                    $.each($('.permission'), function () {
                        $(this).prop('checked', false);
                    });
                }

            });
        });
    </script>
@endsection
