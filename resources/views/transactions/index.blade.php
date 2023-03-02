@extends('layouts.app')

@section('title', 'Transaction')

@section('content')
    {{ Breadcrumbs::render('transactions', $result->customer) }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{$result->customer->name}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Summary
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($result->totalAmount)}}</div>
                                    <div class="h5 mb-0 text-primary text-xs">{{number_format($result->count) }}
                                        <span class="text-primary text-left text-xs">Transactions</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Current Month
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($result->totalAmountMonth)}}</div>
                                    <div class="h5 mb-0 text-primary text-xs">{{number_format($result->countMonth) }}
                                        <span class="text-primary text-left text-xs">Transactions</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
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
                                        Reward
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($result->reward)}}</div>
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
            <h6 class="m-0 font-weight-bold text-primary">{{"Transaction"}}</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th style="white-space: nowrap;width: 20%;">Date</th>
                    </tr>
                    </thead>
                    @foreach ($result->transactions as $key => $transaction)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $transaction->amount > 0 ? "Deposit" : "Withdrawal" }}</td>
                            <td style="color: {{ $transaction->amount > 0 ? ("green"): ("red")}}">{{ number_format($transaction->amount) }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
                {{ $result->transactions->links('components.pagination.custom') }}
            </div>
        </div>
    </div>
    <script src="{{ url('/') }}/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/inputmask.min.js"
            integrity="sha512-czERuOifK1fy7MssE4JJ7d0Av55NPiU2Ymv4R6F0mOGpyPUb9HkP9DcEeE+Qj9In7hWQHGg0CqH1ELgNBJXqGA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#phone_number').mask('+62 000-0000-00000');
    </script>
@endsection
