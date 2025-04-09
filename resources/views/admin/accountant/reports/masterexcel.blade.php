<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Report</title>
</head>
<body>

    <table>
        <tr>
            <th colspan="16" style="text-align: center; font-weight: bolder; font-size: 30px;">{{ $companyName }}</th>
        </tr>
        <tr>
            <th colspan="16" style="text-align: center;"><b>GST No.:</b>{{ $gstNumber }}</th>
        </tr>
        <tr>
            <th colspan="16" style="text-align: center;"><b>PAN No.:</b>{{ $panNumber }}</th>
        </tr>
        <tr>
            <th colspan="16" style="text-align: center;"><b>State:</b> {{ $state }}</th>
        </tr>
    </table>
        <table border="1" style="border: 8px solid #000">
            <thead style="border: 8px solid #000">
                <tr>
                    <th style="font-weight: bold; width: 140px; text-align: center;border: 8px solid #000">PO No.</th>
                    <th style="font-weight: bold; width: 110px; text-align: center;border: 8px solid #000">PO Date</th>
                    <th style="font-weight: bold; width: 110px; text-align: center;border: 8px solid #000">PO Total</th>
                    <th style="font-weight: bold; width: 155px; text-align: center;border: 8px solid #000">Summary No</th>
                    <th style="font-weight: bold; width: 160px; text-align: center;border: 8px solid #000">Invoice No.</th>
                    <th style="font-weight: bold; width: 110px; text-align: center;border: 8px solid #000">Invoice Date</th>
                    <th style="font-weight: bold; width: 190px; text-align: center;border: 8px solid #000">Performa No.</th>
                    <th style="font-weight: bold; width: 110px; text-align: center;border: 8px solid #000">Performa Date</th>
                    <th style="font-weight: bold; width: 110px; text-align: center;border: 8px solid #000">Service Code</th>
                    <th style="font-weight: bold; width: 90px; text-align: center;border: 8px solid #000">QTY</th>
                    <th style="font-weight: bold; width: 90px; text-align: center;border: 8px solid #000">Rate</th>
                    <th style="font-weight: bold; width: 90px; text-align: center;border: 8px solid #000">Total</th>
                    <th style="font-weight: bold; width: 110px; text-align: center;border: 8px solid #000">GST Type</th>
                    <th style="font-weight: bold; width: 80px; text-align: center;border: 8px solid #000">Tax</th>
                    <th style="font-weight: bold; width: 155px; text-align: center;border: 8px solid #000">Amount without GST</th>
                    <th style="font-weight: bold; width: 145px; text-align: center;border: 8px solid #000">Amount with GST</th>
                </tr>
            </thead>
            <tbody style="border: 8px solid #000">
                @foreach ($summaries as $summary)
                    @php
                        $serviceCodeSummary = [];
                        foreach ($summary->summaryProduct as $product) {
                            $code = $product->companyServiceCode->service_code ?? 'N/A';

                            if (!isset($serviceCodeSummary[$code])) {
                                $serviceCodeSummary[$code] = [
                                    'service_code' => $code,
                                    'total_qty' => 0,
                                    'price' => $product->price,
                                ];
                            }

                            $serviceCodeSummary[$code]['total_qty'] += $product->total_qty;
                        }
                        $rowspanCount = count($serviceCodeSummary);
                        $isFirstRow = true;
                    @endphp

                    @foreach ($serviceCodeSummary as $product)
                        <tr style="border: 8px solid #000">
                            @if ($isFirstRow)
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->getPO->po_no ?? 'N/A' }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->getPO->po_date ?? 'N/A' }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->getPO->total ?? 'N/A' }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->sum_no . '/' . str_pad($summary->id, 4, '0', STR_PAD_LEFT) ?? 'N/A' }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->invoice_no }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->invoice_date }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->performa_no }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->performa_date }}</td>
                            @endif

                            <td style="text-align: center;border: 1px solid #000">{{ $product['service_code'] }}</td>
                            <td style="text-align: center;border: 1px solid #000">{{ $product['total_qty'] }}</td>
                            <td style="text-align: center;border: 1px solid #000">{{ $product['price'] }}</td>
                            <td style="text-align: center;border: 1px solid #000">{{ $product['total_qty'] * $product['price'] }}</td>

                            @if ($isFirstRow)
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->gst_type }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->tax }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->price_total }}</td>
                                <td rowspan="{{ $rowspanCount }}" style="text-align: center;border: 1px solid #000; vertical-align: middle;">{{ $summary->gst_amount }}</td>
                            @endif

                            @php $isFirstRow = false; @endphp
                        </tr>
                    @endforeach
                @endforeach
            </tbody>

        </table>


</body>
</html>
