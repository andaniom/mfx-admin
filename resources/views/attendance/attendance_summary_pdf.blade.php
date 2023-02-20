<!DOCTYPE html>
<html>
<head>
    <title>Attendance Summary</title>
</head>
<body>
<h1>Attendance Summary Report</h1>
<table>
    <thead>
    <tr>
    <tr>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Note</th>
    </tr>
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
</body>
</html>
