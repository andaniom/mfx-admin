@extends('layouts.app')

@section('title', 'User')

@section('content')
    {{ Breadcrumbs::render('users') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Users"}}</h6>
        </div>
        <div class="card-body">
            <div class="lead">

            </div>

            <div class="container mt-4">
                <div>
                    Name: {{ $user->name }}
                </div>
                <div>
                    Email: {{ $user->email }}
                </div>
                <div>
                    Phone Number: {{ $user->phone_number }}
                </div>
                <div>
                    Birthday Date: {{ $user->birth_date }}
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info">Edit</a>
                <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
@endsection
