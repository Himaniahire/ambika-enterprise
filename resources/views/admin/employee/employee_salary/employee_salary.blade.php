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
        /* Add more styles as needed */
    </style>
</head>
<body>

    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
        <thead>
            <tr class="row0">
                <th colspan="17" class="style210" style="text-align: center; font-weight: bold; font-size: 30px; height: 100px;">
                    AMBIKA ENTERPRISE (MONTHLY SALARY) <br>
                    @if($companyName) {{ $companyName }} @endif
                </th>
            </tr>
            <tr class="row1">
                <th class="style49" style="border:1px solid black; text-align:center; font-weight: bold;">SR.NO</th>
                <th class="style33" style="width: 200px; border:1px solid black; text-align:center; font-weight: bold;">NAME OF EMPLOYEE</th>
                <th class="style33" style="width: 150px; border:1px solid black; text-align:center; font-weight: bold;">FATHER NAME</th>
                <th class="style33" style="width: 120px; border:1px solid black; text-align:center; font-weight: bold;">DESIGNATION</th>
                <th class="style144" style="width: 100px; border:1px solid black; font-weight: bold; text-align:center;">Rate</th>
                <th class="style144" style="width: 100px; border:1px solid black; font-weight: bold; text-align:center;">Present</th>
                <th class="style144" style="width: 100px; border:1px solid black; font-weight: bold; text-align:center;">OT</th>
                <th class="style144" style="width: 120px; border:1px solid black; font-weight: bold; text-align:center;">Present Amount</th>
                <th class="style144" style="width: 120px; border:1px solid black; font-weight: bold; text-align:center;">OT Amount</th>
                <th class="style144" style="width: 150px; border:1px solid black; font-weight: bold; text-align:center;">Gross Payment</th>
                <th class="style144" style="width: 150px; border:1px solid black; font-weight: bold; text-align:center;">Advance</th>
                <th class="style144" style="width: 150px; border:1px solid black; font-weight: bold; text-align:center;">Remaining Advance</th>
                <th class="style144" style="width: 150px; border:1px solid black; font-weight: bold; text-align:center;">Total Advance</th>
                <th class="style144" style="width: 150px; border:1px solid black; font-weight: bold; text-align:center;">NET Payment</th>
                <th class="style144" style="width: 150px; border:1px solid black; font-weight: bold; text-align:center;">FINAL Payment</th>
                <th class="style144" style="width: 200px; border:1px solid black; font-weight: bold; text-align:center;">A/C NO</th>
                <th class="style144" style="width: 200px; border:1px solid black; font-weight: bold; text-align:center;">IFSC CODE</th>
                <th class="style144" style="width: 250px;border:1px solid black; font-weight: bold; text-align:center;">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                // Initialize totals
                $totalFinalOtAmount = 0;
                $totalFinalPresentAmount = 0;
                $totalFinalTotalAmount = 0;
                $totalNetTotalAmount = 0;
            @endphp

            @foreach($salaries as $salary)
                @php
                    $income = $salary->getEmployee->income ?? 0;
                    $total_present = $salary->total_present ?? 0;
                    $days = $salary->getEmployee->days ?? 1;
                    $additional_amount = $salary->additional_amount ?? 0;
                    $deduct_amount = $salary->deduct_advance ?? 0;

                    if ($salary->getEmployee->income_type == 0) {
                        $present_amount = $income * $total_present;
                    } elseif ($salary->getEmployee->income_type == 1) {
                        $present_amount = ($income * $total_present) / $days;
                    }

                    $present_amount_decimal = number_format($present_amount, 2);
                    $third_digit_present = (int) substr($present_amount_decimal, -1);

                    if ($third_digit_present >= 5) {
                        $final_present_amount = round($present_amount);
                    } else {
                        $final_present_amount = floor($present_amount);
                    }

                    $total_ot = $salary->total_ot ?? 0;
                    $ot_amount = 0;

                    if ($salary->getEmployee->income_type == 0) {
                        $ot_amount = ($income / 8) * $total_ot * 2;
                    } elseif ($salary->getEmployee->income_type == 1) {
                        $ot_amount = (($income / $days) / 10) * $total_ot;
                    }

                    $final_ot_amount = round($ot_amount, 0, PHP_ROUND_HALF_UP);

                    $total_amount = $final_present_amount + $final_ot_amount;

                    if (!is_null($additional_amount)) {
                        $total_amount += $additional_amount;
                    }

                    $total_amount_decimal = number_format($total_amount, 2);
                    $third_digit_total = (int) substr($total_amount_decimal, -1);
                    if ($third_digit_total >= 5) {
                        $final_total_amount = round($total_amount);
                    } else {
                        $final_total_amount = floor($total_amount);
                    }

                    $net_total_amount = $final_total_amount - $deduct_amount;

                    // Accumulate totals
                    $totalFinalOtAmount += $final_ot_amount;
                    $totalFinalPresentAmount += $final_present_amount;
                    $totalFinalTotalAmount += $final_total_amount;
                    $totalNetTotalAmount += $net_total_amount;
                @endphp
                <tr>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $i++ }}</td>
                    <td class="style16" style="border:1px solid black; text-align:center;">{{ $salary->getEmployee->first_name ?? '' }} {{ $salary->getEmployee->last_name ?? '' }}</td>
                    <td class="style16" style="border:1px solid black; text-align:center;">{{ $salary->getEmployee->father_name ?? '' }} {{ $salary->getEmployee->last_name ?? '' }}</td>
                    <td class="style16" style="border:1px solid black; text-align:center;">{{ $salary->getEmployee->getEmployeePost->emp_post ?? '' }}</td>
                    <td class="style16" style="border:1px solid black; text-align:center;">{{ $salary->getEmployee->income ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $total_present ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $salary->total_ot ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $final_present_amount ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $final_ot_amount ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $final_total_amount ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $salary->deduct_advance ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $salary->getEmployee->advance ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $salary->total_advance ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $net_total_amount ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $net_total_amount ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">'{{ $salary->getEmployee->account_no ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $salary->getEmployee->ifsc_code ?? '' }}</td>
                    <td class="style17" style="border:1px solid black; text-align:center;">{{ $salary->note ?? '' }}</td>
                </tr>
            @endforeach

            <tr>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
                <td class="style16" style="border:1px solid black; text-align:center;"></td>
                <td class="style16" style="border:1px solid black; text-align:center;"></td>
                <td class="style16" style="border:1px solid black; text-align:center;"></td>
                <td class="style16" style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;">{{ $totalFinalPresentAmount }}</td>
                <td class="style17" style="border:1px solid black; text-align:center;">{{ $totalFinalOtAmount }}</td>
                <td class="style17" style="border:1px solid black; text-align:center;">{{ $totalFinalTotalAmount }}</td>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;">{{ $totalNetTotalAmount }}</td>
                <td class="style17" style="border:1px solid black; text-align:center;">{{ $totalNetTotalAmount }}</td>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
                <td class="style17" style="border:1px solid black; text-align:center;"></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
