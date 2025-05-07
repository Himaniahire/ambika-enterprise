<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$performas->performa_no}}</title>
    <style>
        body{
            font-family: sans-serif !important;
            margin-top: 20%
        }
        .container {
            font-family: sans-serif !important;
            margin: auto;
            max-width: 100%;
            padding: 0px;
            border: 1px solid #000000;
        }

        @media (max-width: 2560px) {
            .container {
                width: 100%;
                font-family: sans-serif !important;
            }
        }

        @media print {
            .container {
                width: 100% !important;
                font-family: sans-serif !important;
            }
        }

        p,
        table {
            margin: 0px 0;
            font-size: 13px;
            padding: 0px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0px;
            text-align: left;
            font-size: 11px;
            /* font-weight: 500; */
            border-right: 1px solid black;
        }

        tbody {
            padding: 8px 0px;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
        }

        .main {
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between;
            align-items: center;
            padding: 10px 1%;
            width: auto
        }

        .b-n {
            border: none;
        }

        .empty-row {
            height: 300px;
        }

        a {
            text-decoration: none;
            color: #000;
        }

        .header {
            text-align: center;
        }

        .text-red {
            color: #000;
            /* font-weight: 600; */
            font-size: 13px;
        }

        h4 {
            padding: 0px !important;
        }

        h5 {
            font-size: 15px;
            padding: 0px;
            padding: 0px 6px;
        }

        .p-tag {
            font-size: 11px;
            line-height: 20px;
        }

        .one {
            text-align: center;
            padding: 10px;
            border: none !important;
        }

        .middel {
            display: flex;
        }

        .inner {
            border: 1px solid #000;
            width: 27.5%;
            height: 211px;
        }

        .inner-one {
            width: 45%;
            border: 1px solid #000;
            height: 330px;
        }

        .text-center {
            text-align: center;
        }

        .bt {
            border-top: 1px solid #000;
        }

        .table-p {
            font-size: 11px;
        }

        .padding {
            padding: 7px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <p class="text-red"><b>AMBIKA ENTERPRISE</b></h4>
            <p style=" font-size:11px;">453, SASTA ANAJ FALIYA, BORBHATABET, MAKTAMPUR, BHARUCH-391001, GUJARAT, INDIA.</p>
            <p style=" font-size:11px;">(Issued under Section 31 of the central goods and service tax act 2017)</p>
            <p style=" font-size:11px;"><a href="">Email ID: ambikaenterprise06@gmail.com</a></p>
        </div>
        <table>
            <tr>
                <td class="one"><p style=" font-size: 10px;font-family: sans-serif !important;"><b>GST NO: 24BTSPP5086M1ZR <br>PAN: BTSPP5086M</b></p></td>
                <td class="one"><p style=" font-size: 10px;font-family: sans-serif !important;"><b>MSME REG. NO: UDYAM-GJ-060009500 <br>SAC CODE: {{$performas->getCategoryOfService->sac_code ?? '995457'}}</b></p></td>
                    @if ($performas->category_of_service_id === null)
                        <td class="one"><p style=" font-size: 10px;font-family: sans-serif !important;"><b>CATEGORY OF SERVICE : - <br>MO:9033531083</b></p></td>
                    @else
                        <td class="one"><p style=" font-size: 10px;font-family: sans-serif !important;"><b>CATEGORY OF SERVICE : {{strtoupper($performas->getCategoryOfService->category_of_service) }} <br>MO:9033531083</b></p></td>
                    @endif

            </tr>
        </table>

        <table style="width:100%">
            <tr>
                <td class="bt">
                    <p style="padding: 0px 4px;"><b>{{$performas->getCompany->companyname}} {{$performas->com_unit}}</b></p>
                    <p style="padding: 0px 4px;" class="p-tag">{{$performas->getCompany->address_1}}</p>
                    <p style="padding: 0px 4px;" class="p-tag">{{$performas->getCompany->address_2}}</p>
                    <p style="padding: 0px 4px;" class="p-tag">{{$performas->getCompany->address_3}}</p>
                </td>
                <th class="bt">
                    <div class="text-center">
                        <div class="col-3">
                            <p class="p-tag">PRO INVOICE NO: </p>
                            <p class="p-tag" style="font-weight: normal;">{{$performas->performa_no}}</p>
                        </div>
                        @if ($purchaseOrder)
                            <div class="col-3" style="border-top: 1px solid #000;">
                                <p class="p-tag">PO NO:</p>
                                @if ($purchaseOrder->purchaseOrder)
                                    <p class="p-tag" style="font-weight: normal;">{{ $purchaseOrder->purchaseOrder->po_no }}</p>
                                @else
                                    <p class="p-tag">-</p>
                                @endif
                                @if ($performas->jmr_no != null)
                                    <p class="p-tag">JMR NO: {{ $performas->jmr_no }}</p>
                                @endif
                                @if ($performas->capex_no != null)
                                    <p class="p-tag">Capex NO: {{ $performas->capex_no }}</p>
                                @endif
                            </div>
                        @endif

                    </div>
                </th>
                <th class="bt">
                    <div class="text-center">
                        <div class="col-3">
                            <p class="p-tag">INVOICE DATE :</p>
                            <p class="p-tag" style="font-weight: normal;">{{ \Carbon\Carbon::parse($performas->performa_date)->format('d-m-Y') }}</p>
                        </div>

                        @if ($purchaseOrder)
                            <div class="col-3" style="border-top: 1px solid #000;">
                                <p class="p-tag">PO DATE :</p>
                                @if ($purchaseOrder->purchaseOrder)
                                <p class="p-tag" style="font-weight: normal;">{{ \Carbon\Carbon::parse($purchaseOrder->purchaseOrder->po_date)->format('d-m-Y') }}</p>
                            @else
                                <p class="p-tag">-</p>
                            @endif

                            </div>
                        @endif
                    </div>
                </th>
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; ">
                <th rowspan="1" style="border-top: none;" >
                    <p class="p-tag" style="padding: 0 4px;font-weight: normal;"><b>STATE</b>: {{strtoupper($performas->getCompany->state)}}</p>
                    <p class="p-tag" style="padding: 0 4px;font-weight: normal;"><b>GSTIN</b>: {{$performas->getCompany->gstnumber }}</p>
                    <p class="p-tag" style="padding: 0 4px;font-weight: normal;"><b>PAN NO</b>: {{$performas->getCompany->pannumber }}</p>
                    <p class="p-tag" style="padding: 0 4px;font-weight: normal;"><b>Vendor Code</b>: {{$performas->getCompany->vendor_code }}</p>
                </th>
                </th>
                <th colspan="2" class="bt" style="padding:0px;border-left: 1px solid #000;">
                    <div class="text-center">
                        <div class="col-6">
                            <p class="p-tag" style="font-weight: normal;"><b>DEPARTMENT</b>: {{$performas->department}} <br>
                                                                           <b>PLANT</b>: {{$performas->plant}} <br>
                                                                            <b>WORK PERIOD</b>: {{$performas->work_period }}<br>
                                                                            <b>WORK/ CONTRACT ORDER NO</b>: {{$performas->work_contract_order_no }}</p>
                        </div>
                    </div>
                </th>
            </tr>
        </table>
        <table style="margin-top: 0px" >
            <tr class="bt" >
                @if ($performas->tax == NULL)
                    <th class="padding" colspan="3" style="border-right: none">
                        <p>LUT NO:- {{$performas->getCompany->lut_no}} </p>
                    </th>
                    <th class="padding" colspan="4">
                        <p>DOA:- {{\Carbon\Carbon::parse($performas->getCompany->doa)->format('d-m-Y')}}</p>
                    </th>
                @endif
            </tr>
            <tr class="bt">
                <th class="padding">
                    <p class="table-p">SR.NO</p>
                </th>
                <th class="padding">
                    <p class="table-p">JOB DESCRIPTION</p>
                </th>
                <th class="padding" style="width: 50px;text-align:center">
                    <p class="table-p">SERVICE CODE</p>
                </th>
                <th class="padding">
                    <p class="table-p">UOM</p>
                </th>
                <th class="padding"  style="width: 50px">
                    <p class="table-p">QTY</p>
                </th>
                <th class="padding">
                    <p class="table-p">RATE </p>
                </th>
                <th class="padding">
                    <p class="table-p">AMOUNT</p>
                </th>
            </tr>
            @foreach ($products as $product)
                <tr class="bt">
                    <td class="padding">{{$i++}}</td>
                    <td class="padding">{{$product->job_description}}</td>
                    <td class="padding">
                        @if ($product->po_id)
                            {{$product->companyServiceCode->service_code ?? "N/A"}}
                        @else
                            {{$product->companyServiceCode->service_code ?? $product->service_code ?? "N/A"}}
                        @endif
                    </td>
                    <td class="padding">{{$product->companyServiceCode->uom ?? $product->uom}}</td>
                    <td class="padding">{{ number_format(round($product->total_qty, 2), 2, '.', '') }}</td>
                    <td class="padding">{{$product->price}}</td>
                    <td class="padding"><b>{{number_format(round($product->total_qty * $product->price, 2), 2, '.', '')}}</b></td>
                </tr>
            @endforeach
            @foreach ($products as $product)
                @php
                    $price = $product->price;
                    $total_qty = number_format(round($product->total_qty, 2), 2, '.', '');
                    $amount = number_format(round($price * $total_qty, 2), 2, '.', '');
                    $sub_total += $amount;
                @endphp
            @endforeach

            @php
                $grand_total = $performas->gst_amount;
                $tax_difference = $grand_total - $sub_total;

                if ($performas->gst_type == 'CGST/SGST') {
                    $cgst = $sgst = $tax_difference / 2;
                    $igst = 0;
                } elseif ($performas->gst_type == 'IGST') {
                    $igst = $tax_difference;
                    $cgst = $sgst = 0;
                }
            @endphp

            <tr class="bt">
                <th rowspan="1" colspan="5" style="text-align: right;" class="padding">
                    <p class="p-tag">TOTAL TAXABLE VALUE (Rs.)</p>

                    @if ($performas->gst_type == 'CGST/SGST')
                        <p class="p-tag">CGST 9% (Rs.)</p>
                        <p class="p-tag">SGST 9% (Rs.)</p>
                    @elseif ($performas->gst_type == 'IGST')
                        <p class="p-tag">IGST 18% (Rs.)</p>
                    @endif

                    <p class="p-tag">TOTAL GROSS VALUE (Rs.)</p>
                </th>
                <th colspan="2" style="text-align: right;" class="padding">
                    <p class="p-tag">{{ number_format(round($sub_total, 2), 2, '.', '') }}</p>

                    @if ($performas->tax == '0')
                    @else
                        @if ($performas->gst_type == 'CGST/SGST')
                            <p class="p-tag">{{ number_format(round($cgst, 2), 2, '.', '') }}</p>
                            <p class="p-tag">{{ number_format(round($sgst, 2), 2, '.', '') }}</p>
                        @elseif ($performas->gst_type == 'IGST')
                            <p class="p-tag">{{ number_format(round($igst, 2), 2, '.', '') }}</p>
                        @endif
                    @endif

                    <p class="p-tag">
                        @if($performas->tax == '0')
                            {{ number_format(round($sub_total, 2), 2, '.', '') }}
                        @else
                            {{ number_format(round($grand_total, 2), 2, '.', '') }}
                        @endif
                    </p>
                </th>
            </tr>

            <tr>
                <th colspan="7" class="bt">
                    <p class="text-center p-tag" style="font-size: 11px;">Rupees: {{ $word}}</p>
                </th>
            </tr>
            <tr class="bt">
                <th class="padding" colspan="4">
                    <p class="table-p text-center">Bank A/C No : 18990200002923 <br> IFSC : FDRL0001899</p>
                </th>
                <th class="padding" colspan="3">
                    <p class="table-p text-center" style="margin-top: 50px;">Authorised Signatory <br>
                        For AMBIKA ENTERPRISE</p>
                </th>
                </th>
            </tr>
        </table>
    </div>



</body>

</html>
