@extends('layouts.app')

@section('title', 'Permission')

@section('content')
    {{ Breadcrumbs::render('posts-create') }}
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nameInput">Name</label>
            <input value="{{ old('name') }}"
                   name="name" type="text" class="form-control" id="nameInput"
                   aria-describedby="nameHelp" required>

            @if ($errors->has('name'))
                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-default">Back</a>
    </form>
@endsection
