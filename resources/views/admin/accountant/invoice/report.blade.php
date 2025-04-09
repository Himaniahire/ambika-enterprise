@extends('admin.layouts.layout')
@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                                Invoice Report
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content -->
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Account details card -->
                    <div class="card mb-4">
                        <div class="card-header">Invoice Report</div>
                        <div class="card-body">
                            <form action="" method="" id="invoice-form">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Company Name</label>
                                        <select class="form-control" id="company_id" name="company_id">
                                            <option value="">Select Company Name</option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">PO NO</label>
                                        <select class="form-control" id="po_no_id" name="po_no_id">
                                            <option value="">Select PO NO</option>
                                            @foreach ($purchaseOrder as $po)
                                                @if(!is_null($po->po_no))
                                                    <option value="{{ $po->id }}">
                                                        {{ $po->po_no }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Work/Contract Order No</label>
                                        <select class="form-control" id="work_contract_order_no" name="work_contract_order_no">
                                            <option value="">Select Work/Contract Order No</option>
                                            @foreach ($invoices as $invoice)
                                                    @if(!is_null($invoice->work_contract_order_no))
                                                        <option value="{{ $invoice->id }}">
                                                            {{ $invoice->work_contract_order_no }}
                                                        </option>
                                                    @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <label class="small  mb-1" for="inputFirstName">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">Select Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Complete">Complete</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Start Date</label>
                                        <input class="form-control" id="start_date" type="date" name="start_date"
                                            value="" />
                                    </div>
                                    <div class="col-6 col-md-4" id="inputContainer">
                                        <label class="small mb-1" for="inputFirstName">End Date</label>
                                        <input class="form-control" type="date" name="end_date" id="end_date"
                                            value="" />
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <main>
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Account details card -->
                    <div class="card mb-4">
                        <div class="card-header">Invoice Report</div>
                        <div class="card-body">
                            <table id="invoice-list"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('footer-script')
<!-- JavaScript -->
<script src="https://unpkg.com/feather-icons"></script>
<script>


    $(document).ready(function() {
        var dataTable;
        $('#invoice-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("get-invoice") }}',
                data: formData,
                success: function(response) {
                    if (dataTable) {
                        dataTable.destroy();
                    }

                    var dataTable = new DataTable('#invoice-list', {
                        data: response,
                        columns: [
                            {
                                data: null,
                                title: 'Invoice No',
                                render: function(data, type, row) {
                                    return `${data.invoice_no}/00${data.id}`;
                                }
                            },
                            { data: 'invoice_date', title: 'Invoice Date',
                                render: function(data, type, row) {
                                    return data ? data : 'No Invoice Date';
                                }
                             },
                            { data: 'po_no', title: 'PO NO',
                                render: function(data, type, row) {
                                    return data ? data : 'No PO No';
                                }
                             },
                            {
                                data: 'work_contract_order_no',
                                title: 'Work/Contract Order No',
                                render: function(data, type, row) {
                                    return data ? data : 'No Work Order No';
                                }
                            },
                            { data: 'gst_amount', title: 'Total' },
                            {
                                data: null,
                                title: 'Actions',
                                render: function(data, type, row) {
                                    var showUrl = '{{ route("invoice.show", ":id") }}'.replace(':id', data.id);
                                    return `
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                        <li>
                                            <a href="${showUrl}" target="_blank" class="btn btn-sm btn-soft-primary">
                                                <i data-feather="file-text"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    `;
                                }
                            },
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'Copy',
                                title: 'Ambika Enterprise',
                                customize: function (data) {
                                    var grandTotal = calculateGrandTotal(dataTable);
                                    data = data + '\n\nGrand Total: ' + grandTotal;
                                    return data;
                                }
                            },
                            {
                                extend: 'csv',
                                text: 'CSV',
                                title: 'Ambika Enterprise',
                                customize: function (csv) {
                                    var grandTotal = calculateGrandTotal(dataTable);
                                    var csvData = csv.split('\n');
                                    csvData.push('Grand Total,' + grandTotal);
                                    return csvData.join('\n');
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                title: 'Ambika Enterprise',
                                customize: function (xlsx) {
                                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                    var grandTotal = calculateGrandTotal(dataTable);
                                    var lastRow = $('row', sheet).last();
                                    var lastRowIndex = parseInt(lastRow.attr('r')) + 1;

                                    // Construct the new row
                                    var newRow = `
                                        <row r="${lastRowIndex}">
                                            <c t="inlineStr" r="A${lastRowIndex}">
                                                <is><t>Grand Total</t></is>
                                            </c>
                                            <c t="n" r="B${lastRowIndex}">
                                                <v>${grandTotal}</v>
                                            </c>
                                        </row>`;

                                    sheet.childNodes[0].childNodes[1].innerHTML += newRow;
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                title: 'Ambika Enterprise',
                                customize: function (doc) {
                                    var grandTotal = calculateGrandTotal(dataTable);
                                    doc.content.push({
                                        text: 'Grand Total: ' + grandTotal,
                                        style: 'subheader',
                                        alignment: 'right'
                                    });
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Print',
                                title: 'Ambika Enterprise',
                                customize: function (win) {
                                    var grandTotal = calculateGrandTotal(dataTable);
                                    $(win.document.body).append('<div style="text-align: right; font-size: 1.2em;"><strong>Grand Total: ' + grandTotal + '</strong></div>');
                                }
                            }
                        ],
                        drawCallback: function(settings) {
                            var api = this.api();
                            var data = api.rows({ page: 'current' }).data();

                            // Calculate grand total
                            var grandTotal = data.reduce(function(acc, curr) {
                                return acc + parseFloat(curr.total);
                            }, 0).toFixed(2);

                            // Remove existing grand total row if present
                            $('#invoice-list tfoot').remove();

                            // Add grand total row
                            var grandTotalRow = '<tfoot><tr><td></td><td></td><td></td><td>Grand Total:</td><td>' + grandTotal + '</td><td></td></tr></tfoot>';
                            $('#invoice-list').append(grandTotalRow);

                            feather.replace();
                        }
                    });

                    function calculateGrandTotal(dataTable) {
                        var data = dataTable.rows({ page: 'current' }).data().toArray();
                        return data.reduce(function(acc, curr) {
                            return acc + parseFloat(curr.total);
                        }, 0).toFixed(2);
                    }
                },

                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });

</script>


@endsection
