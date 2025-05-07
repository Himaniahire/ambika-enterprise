
<html>
<body>
    <div style="text-align: center;">
        <table style="margin: 0 auto;">
            <thead>
                <tr>
                    <th colspan="{{ $totalColspan }}" style="font-size: 12px; font-family: serif;">
                        {{ $summaries->sum_no }}
                    </th>
                </tr>
                <tr>
                    <th colspan="{{ $totalColspan }}" style="font-size: 30px; font-weight: 500; font-family: serif; text-align: center;">
                        <h1>AMBIKA ENTERPRISE</h1>
                    </th>
                </tr>
                <tr>
                    <th colspan="{{ $totalColspan }}" style="font-size: 15px; font-family: serif; text-align: center;">
                        <h3>MEASUREMENT SHEET</h3>
                    </th>
                </tr>
                <tr>
                    <th colspan="{{ $totalColspan }}" style="font-size: 15px; font-family: serif; text-align: center;">
                        <h3>Company Name: {{ $summaries->getCompany->companyname }} {{ $summaries->com_unit }}</h3>
                    </th>
                </tr>
                <tr>
                    <th colspan="{{ $totalColspan }}" style="font-size: 15px; font-family: serif; text-align: center;">
                        <h4>PLANT: {{ $summaries->plant }} MONTH: {{ strtoupper($summaries->summ_date) }}</h4>
                    </th>
                </tr>
                <tr>
                    <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000; width: 120px;">DATE</th>
                    <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">Page No</th>
                    <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">Sr/No</th>
                    @foreach ($descriptionArr as $index => $description)
                        <th colspan="4" style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">{{ $description }}</th>
                        <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">TOTAL <br>{{ $uomArr[$index] }}</th>
                    @endforeach
                    <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">REMARKS</th>
                </tr>
                <tr>
                    <th style="border: 2px solid #000;">&nbsp;</th>
                    <th style="border: 2px solid #000;">&nbsp;</th>
                    <th style="border: 2px solid #000;">&nbsp;</th>
                    @foreach ($descriptionArr as $description)
                        <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">L</th>
                        <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">W</th>
                        <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">H</th>
                        <th style="font-size: 9px; text-align: center; font-family: serif; font-weight: 500; border: 2px solid #000;">Nos</th>
                        <th style="border: 2px solid #000;">&nbsp;</th>
                    @endforeach
                    <th style="border: 2px solid #000;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @php $descGrandTot = []; $i = 1; @endphp
                @foreach ($summaries->summaryProducts as $productVal)
                    <tr>
                        <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">{{ $productVal['sum_date'] }}</td>
                        <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">{{ $productVal['pg_no'] }}</td>
                        <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">{{ $i++ }}</td>
                        @foreach ($descriptionArr as $description)
                            @if ($description == $productVal['job_description'])
                                <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">{{ $productVal['length'] }}</td>
                                <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">{{ $productVal['width'] }}</td>
                                <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">{{ $productVal['height'] }}</td>
                                <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">{{ $productVal['nos'] }}</td>
                                <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">{{ $productVal['total_qty'] }}</td>
                                @php $descGrandTot[$description][] = $productVal['total_qty']; @endphp
                            @else
                                <td style="border: 2px solid #000;">&nbsp;</td>
                                <td style="border: 2px solid #000;">&nbsp;</td>
                                <td style="border: 2px solid #000;">&nbsp;</td>
                                <td style="border: 2px solid #000;">&nbsp;</td>
                                <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">0</td>
                            @endif
                        @endforeach
                        <td style="border: 2px solid #000;">&nbsp;</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right; font-family: serif; border: 2px solid #000;">
                        <strong>TOTAL</strong>
                    </td>
                    @foreach ($descriptionArr as $description)
                        <td style="border: 2px solid #000;">&nbsp;</td>
                        <td style="border: 2px solid #000;">&nbsp;</td>
                        <td style="border: 2px solid #000;">&nbsp;</td>
                        <td style="border: 2px solid #000;">&nbsp;</td>
                        <td style="font-size: 11px; text-align: center; font-family: serif; border: 2px solid #000;">
                            {{ array_sum($descGrandTot[$description] ?? []) }}
                        </td>
                    @endforeach
                    <td style="border: 2px solid #000;">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

