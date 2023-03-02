@extends('layouts.app')

@section('title', 'Customer')

@section('content')
    {{ Breadcrumbs::render('customers') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Customer"}}</h6>
            <div>
                <a data-toggle="modal" data-target="#customerModal" class="btn btn-primary btn-sm">Add
                    Customer</a>
            </div>
        </div>

        <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customerModalLabel">Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('customers.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_number" class="col-form-label">Phone Number:</label>
                                <input id="phone_number" type="text"
                                       class="form-control phone @error('phone_number') is-invalid @enderror"
                                       name="phone_number" required
                                       autocomplete="phone_number" autofocus placeholder="+62 000-0000-00000">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>

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
                                    <a data-toggle="modal"
                                       data-target="#{{str_replace(" ", "", $customer->name)}}-modal"
                                       style="width: 100px"
                                       class="btn btn-info btn-sm mt-1">Order</a>
                                    <a style="width: 100px" class="btn btn-info btn-sm mt-1"
                                       href="{{route('transactions.index', $customer->id)}}">History</a>
                                    <a style="width: 100px" class="btn btn-info btn-sm mt-1">Edit</a>
                                </div>

                                <div class="modal fade" id="{{str_replace(" ", "", $customer->name)}}-modal"
                                     role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Create Order</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post"
                                                      action="{{route('transactions.store', $customer->id)}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Type Order:</label>
                                                        <select id="" class="form-control" name="type">
                                                            <option value="deposit">Deposit</option>
                                                            <option value="withdrawal">Withdrawal</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="amount" class="col-form-label">Amount:</label>
                                                        <input type="number" class="form-control" id="amount"
                                                               name="amount" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $customers->links('components.pagination.custom') }}
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
