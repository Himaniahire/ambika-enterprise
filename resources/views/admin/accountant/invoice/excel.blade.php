<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: sans-serif;
            margin-top: 20px; /* corrected margin unit */
        }
        .container {
            margin: auto;
            max-width: 100%;
            padding: 10px;
            border: 1px solid #000;
        }
        @media print {
            .container {
                width: 100% !important;
            }
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            border: 1px solid #000;
            text-align: left;
            font-size: 12px;
        }
        .header {
            text-align: center;
        }
        .text-red {
            color: #000;
            font-size: 14px;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .bt {
            border-top: 1px solid #000;
        }
        .padding {
            padding: 5px;
        }
        .p-tag {
            margin: 0;
            font-size: 11px;
        }
        .one {
            border-right: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="header">
            <tr class="text-red">
                <th colspan="6" style="width: 100%; text-align: center; width:70px; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;"><b>AMBIKA ENTERPRISE</b></th>
            </tr>
            <tr class="p-tag">
                <th colspan="6" style="width: 100%; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;">453, SASTA ANAJ FALIYA, BORBHATABET, MAKTAMPUR, BHARUCH-391001, GUJARAT, INDIA.</th>
            </tr>
            <tr class="p-tag">
                <th colspan="6" style="width: 100%; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;">(Issued under Section 31 of the central goods and service tax act 2017)</th>
            </tr>
            <tr class="p-tag">
                <th colspan="6" style="width: 100%; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;"><b>INVOICE</b></th>
            </tr>
            <tr>
                <td class="one" colspan="2" style="height: 40px; text-align: center; border-left: 1px solid #000;">
                    <p class="p-tag"><b>GST NO: 24BTSPP5086M1ZR <br>PAN: BTSPP5086M</b></p>
                </td>
                <td class="one" colspan="1" style="height: 40px; text-align: center;">
                    <p class="p-tag"><b>MSME REG. NO: UDYAM-GJ-060009500 <br>SAC CODE: 995457</b></p>
                </td>
                <td class="one" colspan="3" style="height: 40px; text-align: center; border-right: 1px solid #000;" >
                    <p class="p-tag"><b>CATEGORY OF SERVICE :@if ($invoice->category_of_service_id === null) - @else {{ strtoupper($invoice->getCategoryOfService->category_of_service) }} @endif
                    <br>MO: 9033531083</b></p>
                </td>
            </tr>
            <tr>
                <th class="bt" colspan="3" style="border-left: 1px solid #000; border-right: 1px solid #000; border-top: 1px solid #000;">
                    <p class="p-tag"><b>{{ $invoice->getCompany->companyname }} {{ $invoice->com_unit }} </b></p>
                </th>
                <th class="bt" colspan="3" style=" border-right: 1px solid #000; border-top: 1px solid #000;">
                    <div class="text-center">
                        <p class="p-tag"><b>INVOICE NO: </b>{{ $invoice->invoice_no }}</p>
                        @if ($purchaseOrder)
                            <p class="p-tag"><b>PO NO: </b>{{ $purchaseOrder->purchaseOrder ? $purchaseOrder->purchaseOrder->po_no : '-' }}</p>
                            @if ($invoice->jmr_no != null)
                                <p class="p-tag"><b>JMR NO: </b>{{ $invoice->jmr_no }}</p>
                            @endif
                        @endif
                    </div>
                </th>
            </tr>
            <tr>
                <th class="bt" colspan="3" style="border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag">{{ $invoice->getCompany->address_1 }}</p>
                </th>
                <th class="bt" colspan="3" style="border-right: 1px solid #000;">
                    <div class="text-center">
                        <p class="p-tag"><b>INVOICE DATE: </b>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</p>
                        @if ($purchaseOrder)
                            <p class="p-tag"><b>PO DATE: </b>{{ $purchaseOrder->purchaseOrder ? $purchaseOrder->purchaseOrder->po_date : '-' }}</p>
                        @endif
                    </div>
                </th>
            </tr>
            <tr>
                <th class="bt" colspan="3" style="border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag">{{ $invoice->getCompany->address_2 }}</p>
                </th>
                <th class="bt" colspan="3" style="border-right: 1px solid #000;">
                    <p class="p-tag"><b>DEPARTMENT: </b> {{ $invoice->department }}</p>
                </th>
            </tr>
            <tr>
                <th class="bt" colspan="3" style="border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag">{{ $invoice->getCompany->address_3 }}</p>
                </th>
                <th class="bt" colspan="3" style="border-right: 1px solid #000;">
                    <p class="p-tag"><b>PLANT: </b> {{ $invoice->plant }}</p>
                </th>
            </tr>
            <tr>
                <th class="bt" colspan="3" style="border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag">STATE: {{ strtoupper($invoice->getCompany->state) }}</p>
                </th>
                <th class="bt" colspan="3" style="border-right: 1px solid #000;">
                    <p class="p-tag"><b>WORK PERIOD: </b> {{ $invoice->work_period }}</p>
                </th>
            </tr>
            <tr>
                <th class="bt" colspan="3" style="border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag">GSTIN: {{ $invoice->getCompany->gstnumber }}</p>
                </th>
                <th class="bt" colspan="3" style="border-right: 1px solid #000;">
                    <p class="p-tag"><b>WORK/ CONTRACT ORDER NO:</b> {{ $invoice->work_contract_order_no }}</p>
                </th>
            </tr>
            <tr>
                <th class="bt" colspan="3" style="border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag">PAN NO: {{ $invoice->getCompany->pannumber }}</p>
                </th>
                <th class="bt" colspan="3" style="border-right: 1px solid #000;">
                </th>
            </tr>
            <tr>
                <th class="bt" colspan="3" style="border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag">Vendor Code: {{ $invoice->getCompany->vendor_code }}</p>
                </th>
                <th class="bt" colspan="3" style="border-right: 1px solid #000;">
                </th>
            </tr>
            @if ($invoice->tax == NULL)
                <tr>
                    <td colspan="3" class="padding" style="border-left: 1px solid #000;">
                        <p><b>LUT NO: - AD2404240149753</b></p>
                    </td>
                    <td colspan="3" class="padding" style="border-right: 1px solid #000;">
                        <p><b>DOA: 08/04/2024</b></p>
                    </td>
                </tr>
            @endif
            <tr>
                <th class="padding" style="width: 50px; border: 1px solid #000;"><p class="p-tag"><b>SR.NO</b></p></th>
                <th class="padding" style="width: 100px; border: 1px solid #000;"><p class="p-tag"><b>SERVICE CODE</b></p></th>
                <th class="padding" style="width: 250px; border: 1px solid #000;"><p class="p-tag"><b>JOB DESCRIPTION</b></p></th>
                <th class="padding" style="width: 60px; border: 1px solid #000;"><p class="p-tag"><b>QTY</b></p></th>
                <th class="padding" style="width: 60px; border: 1px solid #000;"><p class="p-tag"><b>RATE</b></p></th>
                <th class="padding" style="width: 90px; border: 1px solid #000;"><p class="p-tag"><b>AMOUNT</b></p></th>
            </tr>
            @php $i = 1; $sub_total = 0; @endphp
            @foreach ($products as $product)
                <tr>
                    <td class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{ $i++ }}</td>
                    <td class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{ $product->companyServiceCode->service_code ?? "N/A"}}</td>
                    <td class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{ $product->job_description }}</td>
                    <td class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><b>{{ $product->total_qty }}</b></td>
                    <td class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><b>{{ $product->price }}</b></td>
                    <td class="padding" style="text-align: right; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><b>{{ number_format($product->total_qty * $product->price, 2, '.', '') }}</b></td>
                </tr>
                @php $sub_total += $product->total_qty * $product->price; @endphp
            @endforeach
            @php
                $grand_total = $invoice->gst_amount;
                $count = $grand_total - $sub_total;
                $cgst = $sgst = $igst = $count / 2;
            @endphp
            <tr>
                <td colspan="3" style="border-left: 1px solid #000; "></td>
                <td colspan="2" class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag"><b>TOTAL (Rs.):</b></p>
                </td>
                <td class="padding" style="text-align: right; border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag"><b>{{ number_format($sub_total, 2, '.', '') }}</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-left: 1px solid #000;"></td>
                <td colspan="2" class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag"><b>CGST 9% (Rs.):</b></p>
                </td>
                <td class="padding" style="text-align: right; border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag"><b>{{ number_format($cgst, 2, '.', '') }}</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-left: 1px solid #000;"></td>
                <td colspan="2" class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag"><b>SGST 9% (Rs.):</b></p>
                </td>
                <td class="padding" style="text-align: right; border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag"><b>{{ number_format($sgst, 2, '.', '') }}</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-left: 1px solid #000;"></td>
                <td colspan="2" class="padding" style="text-align: left; border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag"><b>TOTAL GROSS VALUE (Rs.):</b></p>
                </td>
                <td class="padding" style="text-align: right; border-left: 1px solid #000; border-right: 1px solid #000;">
                    <p class="p-tag"><b>{{ $grand_total }}</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="6" class="padding" style="text-align: center; border-left: 1px solid #000; border-right: 1px solid #000; border-top: 1px solid #000;">
                    <p class="p-tag"><b>Rupees: {{ $word }}</b></p>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="padding" style="text-align: center; border-left: 1px solid #000; border-right: 1px solid #000; border-top: 1px solid #000;">
                    <p class="p-tag text-center"><b>Bank A/C No: 18990200002923</b></p>
                </td>
                <td colspan="3" rowspan="3" class="padding" style="text-align: center; border-left: 1px solid #000; border-right: 1px solid #000; border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <p class="p-tag text-center">Authorised Signatory<br><br>For AMBIKA ENTERPRISE</p>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="padding" style="text-align: center; border-left: 1px solid #000;">
                    
                </td>
            </tr>
            <tr>
                <td colspan="3" class="padding" style="text-align: center; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">
                    <p class="p-tag text-center"><b>IFSC: FDRL0001899</b></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
