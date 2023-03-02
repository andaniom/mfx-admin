@extends('layouts.app')

@section('title', 'User')

@section('content')
    {{ Breadcrumbs::render('users') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Users"}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-3 text-gray-900">Name</div>
                        <div>{{ $user->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-3 text-gray-900">Email</div>
                        <div>{{ $user->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-3 text-gray-900">Phone Number</div>
                        <div>{{ $user->phone_number }}</div>
                    </div>
                    <div class="row">
                        <div class="col-3 text-gray-900">Birthday Date</div>
                        <div>{{ $user->birth_date }}</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Customer
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold text-gray-800">{{$customers->total()}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Reward Current Month
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($reward)}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                       href="{{route('transactions.admin', [$customer->id, $user->id])}}">History</a>
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
