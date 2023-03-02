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

    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Customers"}}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Amount</th>
                        <th width="3%" colspan="3">Action</th>
                    </tr>
                    </thead>
                    @foreach ($customers as $key => $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ number_format($customer->amount) }}</td>
                            <td>
                                <div class="d-flex flex-col">
                                    <a style="width: 100px" class="btn btn-info btn-sm mt-1"
                                       href="{{route('transactions.index', $customer->id)}}">History</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $customers->links('components.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
