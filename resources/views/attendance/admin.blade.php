@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    {{ Breadcrumbs::render('attendance') }}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form id="filterForm" action="{{route('attendance.admin')}}" method="GET">
                <label for="user_id">Filter by User:</label>
                <div class="form-group">
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach($users as $user)
                            <option
                                value="{{ $user->id }}" {{ request()->input('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
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
                <button type="submit" name="action" value="download" class="btn btn-primary">Download</button>
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
                                <li>Early
                                    Out {{\App\Models\Attendance::minutesToHourString($attendance->early_out_time)}}</li>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
                        {{ $attendances->appends(request()->input())->links('components.pagination.custom') }}
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#searchButton").click(function () {
                const startDate = $("#startDate").val();
                const endDate = $("#endDate").val();

                $.ajax({
                    type: "GET",
                    url: "/attendance",
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                    },
                    success: function (data) {
                        // Handle the search result here
                        // ...
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
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
    </style>
@endsection
