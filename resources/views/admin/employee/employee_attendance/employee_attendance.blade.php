<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        /* Define your styles here */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        .sunday {
            background-color: red;
            /* Add any other styles for Sundays here */
        }
        @if($exportType === 'pdf')
            table {
                border-collapse: collapse;
                width: 70%;
                margin-left: auto;
                margin-right: auto;
            }
            th, td {
                padding: 1px;
                text-align: left;
            }
            .sunday {
                background-color: #FF6347;
                color: white;
            }
        @endif
    </style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
    <thead>
        <tr class="row0">

            <th colspan="{{ 7 + $monthDate->daysInMonth }}" class="style210" style="text-align: center; font-weight: bold; font-size: 30px; height: 100px;">
                AMBIKA ENTERPRISE {{ strtoupper($companyName) }} (DAY TO DAY ATTENDENCE) <br> {{ strtoupper($monthDate->format('F Y')) }}
            </th>
        </tr>
        <tr class="row1">
            <th class="style49" style="border:1px solid black; text-align:center; font-weight: bold;" rowspan="2">SR.NO</th>
            <th class="style33" style="width: 140px; border:1px solid black; text-align:center; font-weight: bold;" rowspan="2">NAME OF EMPLOYEE</th>
            <th class="style33" style="width: 135px; border:1px solid black; text-align:center; font-weight: bold;" rowspan="2">FATHER NAME</th>
            <th class="style33" style="width: 100px; border:1px solid black; text-align:center; font-weight: bold;" rowspan="2">DESIGNATION</th>
            <th class="style33" style="width: 125px; border:1px solid black; text-align:center; font-weight: bold;" rowspan="2">EMPLOYEE CODE</th>
            @for ($day = 1; $day <= $monthDate->daysInMonth; $day++)
                @php
                    $date = \Carbon\Carbon::createFromDate($monthDate->year, $monthDate->month, $day);
                    $isSunday = ($date->dayOfWeek == \Carbon\Carbon::SUNDAY);
                @endphp
                <th class="style139 date" style="width: 35px; text-align:center; border: 1px solid black; {{ $isSunday ? 'background-color: #FF0066;' : '' }}">
                    {{ $date->format('D') }}
                </th>
            @endfor
            <th class="style144" style="border:1px solid black; font-weight: bold; text-align:center;" rowspan="2">PRESENT</th>
            <th class="style144" style="border:1px solid black; font-weight: bold; text-align:center;" rowspan="2">OT</th>
        </tr>
        <tr class="row1">
            @for ($day = 1; $day <= $monthDate->daysInMonth; $day++)
                @php
                    $date = \Carbon\Carbon::createFromDate($monthDate->year, $monthDate->month, $day);
                    $isSunday = ($date->dayOfWeek == \Carbon\Carbon::SUNDAY);
                @endphp
                <th class="style139 date" style="width: 35px; text-align:center; border: 1px solid black; {{ $isSunday ? 'background-color: #FF0066;' : '' }}">
                    {{ $day }}
                </th>
            @endfor
    </thead>
    <tbody>
        @php
            $employees = $attendances->groupBy('getEmployee.id');
        @endphp
        @foreach($employees as $employeeId => $attendances)
            @php
                $employee = $attendances->first()->getEmployee;
            @endphp
            <tr>
                @php
                    $status = $employee->status;  // 1 = Active, 0 = Inactive, 2 = Terminated, 3 = Resigned
                    $statusColor = '';
                    switch ($status) {
                        case 1:  // Active
                            $statusColor = '';
                            break;
                        case 0:  // Inactive
                            $statusColor = '#D3D3D3';
                            break;
                        case 2:  // Terminated
                            $statusColor = '#FF0000';
                            break;
                        case 3:  // Resigned
                            $statusColor = '#FF0000';
                            break;
                        default:
                            $statusColor = '';
                            break;
                    }
                @endphp
                <td class="style7" style="border:1px solid black; text-align:center; background: {{ $statusColor }};">{{ $loop->iteration }}</td>
                <td class="style3" style="border:1px solid black; text-align:center; background: {{ $statusColor }};">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                <td class="style3" style="border:1px solid black; text-align:center; background: {{ $statusColor }};">{{ $employee->father_name }} {{ $employee->last_name }}</td>
                <td class="style3" style="border:1px solid black; text-align:center; background: {{ $statusColor }};">{{ $employee->getEmployeePost->emp_post ?? ''}}</td>
                <td class="style16" style="border:1px solid black; text-align:center; background: {{ $statusColor }};">{{ $employee->emp_code }}</td>
                @for ($day = 1; $day <= $monthDate->daysInMonth; $day++)
                    @php
                        $date = $monthDate->copy()->day($day)->format('Y-m-d');
                        $attendance = $attendances->where('attendance_date', $date)->first();
                        $displayStatus = '';
                        $displayOvertime = '';

                        if ($attendance) {
                            switch ($attendance->status) {
                                case 1:
                                    $displayStatus = 'P';
                                    $displayOvertime = $attendance->over_time;
                                    break;
                                case 0:
                                    $displayStatus = 'A';
                                    break;
                                case 2:
                                    $displayStatus = 'H';
                                    $displayOvertime = $attendance->over_time * 2;
                                    break;
                                case 3:
                                    $displayStatus = 'H/O';
                                    $displayOvertime = $attendance->over_time;
                                    break;
                                case 4:
                                    $displayStatus = $monthDate->copy()->day($day)->isSunday() ? 'W/O' : '';
                                    $displayOvertime = $attendance->over_time;
                                    break;
                            }
                        } elseif ($monthDate->copy()->day($day)->isSunday()) {
                            $displayStatus = 'W/O';
                            $displayOvertime = $attendances->where('attendance_date', $date)->sum('over_time');
                        }

                        // Define background color based on $displayStatus
                        switch ($displayStatus) {
                            case 'P':
                                $bgColor = '#CCCC66';  // Present
                                break;
                            case 'A':
                                $bgColor = '#FFC7CE';  // Absent
                                break;
                            case 'H':
                                $bgColor = '#91B4F6';  // Holiday
                                break;
                            case 'H/O':
                                $bgColor = '#B39DDB';  // Half-day
                                break;
                            case 'W/O':
                                $bgColor = '#FFD965';  // Work-off
                                break;
                            default:
                                $bgColor = '#FFFFFF';  // Default
                                break;
                        }
                    @endphp
                    <td class="style7" style="background-color: {{ $bgColor }}; border:1px solid black; text-align:center;">{{ $displayStatus }}</td>
                @endfor
                <td class="style17" style="border:1px solid black; text-align:center;">
                    @php
                        $countP = $attendances->where('status', 1)->count();
                    @endphp
                    {{ $countP }}
                </td>
                <td style="border:1px solid black; text-align:center;"></td>
            </tr>
            <tr>
                <td class="style7" style="border:1px solid black; text-align:center;"></td>
                <td class="style3" style="border:1px solid black; text-align:center;"></td>
                <td class="style3" style="border:1px solid black; text-align:center;"></td>
                <td class="style3" style="border:1px solid black; text-align:center;"></td>
                <td class="style16" style="border:1px solid black; text-align:center;"></td>
                @for ($day = 1; $day <= $monthDate->daysInMonth; $day++)
                    @php
                        $date = $monthDate->copy()->day($day)->format('Y-m-d');
                        $attendance = $attendances->where('attendance_date', $date)->first();
                        $displayOvertime = '';

                        if ($attendance) {
                            if ($attendance->status == 1 || $attendance->status == 3) {
                                // Display overtime for present and half-day statuses
                                $displayOvertime = $attendance->over_time;
                            } elseif ($monthDate->copy()->day($day)->isSunday()) {
                                // Sum overtime for work-off days
                                $displayOvertime = $attendances->where('attendance_date', $date)->sum('over_time');
                            }
                        }
                    @endphp
                    <td class="style7" style="background-color: {{ $bgColor }}; border:1px solid black; text-align:center;">
                        {{ $displayOvertime }}
                    </td>
                @endfor

                <td style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;">{{ $attendances->sum('over_time') }}</td>
            </tr>
        @endforeach
    </tbody>

</table>

</body>

</html>
