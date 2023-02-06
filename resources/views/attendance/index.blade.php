@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    {{ Breadcrumbs::render('attendance') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Attendance"}}</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div id="liveClock"></div>
            <div class="btns">
                <button id="checkIn" class="btn btn-primary" {{ $is_check_in ? 'disabled' : '' }}>Check In
                </button>
                <button id="checkOut" class="btn btn-danger" {{ $is_check_out ? 'disabled' : ''}}>Check Out
                </button>
            </div>
        </div>

    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('attendance.index') }}" method="get">
                @csrf
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Note</th>
                </tr>
                </thead>
                @foreach($attendances as $attendance)
                    <tbody
                        style="{{($attendance->is_late || $attendance->is_early_out) ? 'background-color: yellow' : ''}}">
                    <tr>
                        <td>{{ date('l, d F Y', strtotime($attendance->date)) }}</td>
                        <td>{{ $attendance->check_in }}</td>
                        <td>{{ $attendance->check_out }}</td>
                        <td>
                            @if($attendance->is_late)
                                <li>Late {{\App\Models\Attendance::minutesToHourString($attendance->late_time)}}</li>
                            @endif
                            @if($attendance->is_early_out)
                                <li>Early Out {{\App\Models\Attendance::minutesToHourString($attendance->early_out_time)}}</li>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
            {{ $attendances->links('components.pagination.custom') }}
        </div>
    </div>
    <script>
        // Get the clock element
        let clock = document.getElementById("liveClock");

        // Function to update the clock display
        function updateClock() {
            let date = new Date();
            clock.innerHTML = date.toLocaleTimeString();
        }

        // Update the clock every 1000 milliseconds (1 second)
        setInterval(updateClock, 1000);

        // Get the Check In button
        let checkIn = document.getElementById("checkIn");

        // Add a click event listener to the Check In button
        checkIn.addEventListener("click", function () {
            $.ajax({
                url: '/attendance/checkin',
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    location.reload();
                },
                error: function (response) {
                    // Handle the error response
                }
            });
        });

        let checkOut = document.getElementById("checkOut");

        // Add a click event listener to the Check Out button
        checkOut.addEventListener("click", function () {
            $.ajax({
                url: '/attendance/checkout',
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    location.reload();
                },
                error: function (response) {
                    // Handle the error response
                }
            });
        });
    </script>

    <style>
        /* Style the table */
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        /* Style the table cells */
        td, th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        /* Style the table header cells */
        th {
            background-color: #ddd;
        }

        /* Center the live clock */
        #liveClock {
            text-align: center;
            font-size: 36px;
        }

        .btn {
            width: 100px;
            padding: 10px;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            margin: 10px;
            cursor: pointer;
        }

        /* Center the buttons */
        .btns {
            display: flex;
            justify-content: center;
        }
    </style>
@endsection
