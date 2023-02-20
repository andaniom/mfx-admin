@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    {{ Breadcrumbs::render('posts-create') }}
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @method('put')
        @csrf
        <div class="mb-3">
            <label for="nameInput">Name</label>
            <input value="{{ $role->name }}"
                   name="name" type="text" class="form-control" id="nameInput"
                   aria-describedby="nameHelp" required>

            @if ($errors->has('name'))
                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
            @endif

            <label for="permissions" class="form-label">Assign Permissions</label>

            <table class="table table-striped">
                <thead>
                <th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
                <th scope="col" width="20%">Name</th>
                <th scope="col" width="1%">Guard</th>
                </thead>

                @foreach($permissions as $permission)
                    <tr>
                        <td>
                            <input type="checkbox"
                                   name="permission[{{ $permission->name }}]"
                                   value="{{ $permission->name }}"
                                   class='permission'
                                {{ in_array($permission->name, $rolePermissions)
                                    ? 'checked'
                                    : '' }}>
                        </td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }

            });
        });
    </script>
@endsection
