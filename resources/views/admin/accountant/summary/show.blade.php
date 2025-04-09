<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AE/{{ $summaries->sum_no}}</title>
    <style>
        h1,
        h3,
        h4 {
            text-align: center
        }

        table {
            border-collapse: collapse;
            width: auto;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    @php
        $date = $summaries->summ_date;
        // Check if the date is in 'd-m-Y' format
        $isDateFormat = \Carbon\Carbon::hasFormat($date, 'd-m-Y');
    @endphp


    <h5>{{ $summaries->sum_no}}</h5>
    <h1>AMBIKA ENTERPRISE</h1>
    <h3>MEASUREMENT SHEET</h3>
    <h3>Company Name:- {{ $summaries->getCompany->companyname }} {{ $summaries->com_unit }}</h3>
    <h4>PLANT :- {{ $summaries->plant }} MONTH:- @if ($isDateFormat)
        {{ \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('M-Y') }}
    @else
        {{ $date }}
    @endif </h4>

<div style="text-align: center;">
    <table style="margin: 0 auto;">
        <thead>
            <tr>
                <th>DATE</th>
                <th>Page No</th>
                <th>Sr/No</th>
                @foreach ($descriptionArr as $index => $description)
                    <th colspan="4">{{ $description}}</th>
                    <th>TOTAL <br>{{ $uomArr[$index] }}</th>
                @endforeach
                <th>REMARKS</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                @foreach ($descriptionArr as $description)
                    <th>L</th>
                    <th>W</th>
                    <th>H</th>
                    <th>Nos</th>
                    <th></th>
                @endforeach
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
            $descGrandTot = []; @endphp

            @if (!empty($summaries) && !empty($summaries->summaryProducts))
                @foreach ($summaries->summaryProducts as $productKey => $productVal)
                    <tr>
                        <td width="57">{{ $productVal['sum_date'] }}</td>
                        <td>{{ $productVal['pg_no'] }}</td>
                        <td>{{ $i++ }}</td>
                        @foreach ($descriptionArr as $description)
                            @php $j = 0; @endphp
                            @if ($description == $productVal['job_description'])
                                <td>{{ $productVal['length'] }}</td>
                                <td>{{ $productVal['width'] }}</td>
                                <td>{{ $productVal['height'] }}</td>
                                <td>{{ $productVal['nos'] }}</td>
                                <td>{{ $productVal['total_qty'] }}</td>
                                {{ $descGrandTot[$description][] = $productVal['total_qty'] }}
                                {{ $j++ }}
                            @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                            @endif
                        @endforeach
                        <td></td>
                    </tr>
                @endforeach
            @endif
                <tr>
                    <td colspan="3"><strong>TOTAL</strong></td>
                    @foreach ($descriptionArr as $description)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ array_sum($descGrandTot[$description]) }}</td>
                    @endforeach
                    <td></td>
                </tr>
        </tbody>
    </table>
</div>
</body>

</html>
