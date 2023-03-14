@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
    {{ Breadcrumbs::render('transactionsAdmin') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Transactions"}}</h6>
        </div>

        <div class="card-body">
            <form id="filterForm" action="{{route('transactions.admin.index')}}" method="GET">
                <label for="user_id">Filter by User:</label>
                <div class="form-group">
                    <select name="user_id" id="user_id" class="form-control">
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input id="start_date" type="date" name="start_date" value="{{ request()->input('start_date') }}"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input id="end_date" type="date" name="end_date" value="{{ request()->input('end_date') }}"
                           class="form-control">
                </div>
                <button type="submit" name="action" value="search" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="card-body">
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <div class="form-group">{{number_format($total_amount)}} / {{$count}} Transactions </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Transaction Date</th>
                    </tr>
                    </thead>
                    @foreach ($transactions as $key => $transaction)
                        <tr>
                            <td>{{ $transaction->name }}</td>
                            <td>{{ number_format($transaction->amount) }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
                {{ $transactions->links('components.pagination.custom') }}
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{route('users.list')}}',
            method: 'GET',
            success: function (response) {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                for (const key in response){
                    const user_id = urlParams.get('user_id')
                    $("#user_id").append(new Option(response[key].name, response[key].id, false, response[key].id==user_id));
                }
            },
            error: function (response) {
                console.log(response)
                // Handle the error response
            }
        });

    </script>
@endsection
