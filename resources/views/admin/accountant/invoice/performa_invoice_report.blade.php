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
                                Performa And Invoice Report
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
                        <div class="card-header">Performa And Invoice Report</div>
                        <div class="card-body">
                            <form action="" method="" id="invoice-performa-form">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-6">
                                        <label class="small mb-1" for="inputFirstName">Company Name</label>
                                        <select class="form-control" id="company_id" name="company_id">
                                            <option value="">All Compnies</option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label class="small  mb-1" for="inputFirstName">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">Select Status</option>
                                            <option value="All">All</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Complete">Complete</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label class="small mb-1" for="inputFirstName">Start Date</label>
                                        <input class="form-control" id="start_date" type="date" name="start_date"
                                            value="" />
                                    </div>
                                    <div class="col-6 col-md-6" id="inputContainer">
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
                            <table id="invoice-performa-list"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('footer-script')
<!-- JavaScript -->

<script>

$(document).ready(function() {
    var dataTable;
    $('#invoice-performa-form').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        // Modify formData to send an empty value for company_id if "All Companies" is selected
        if ($('#company_id').val() === "") {
            formData += '&company_id=';
        }
        $.ajax({
            type: 'POST',
            url: '{{ route("get-invoice-performa") }}',
            data: formData,
            success: function(response) {
                if (dataTable) {
                    dataTable.destroy();
                }

                dataTable = new DataTable('#invoice-performa-list', {
                    data: response.data,
                    columns: [
                        { data: 'performa_no', title: 'Performa No' },
                        { data: 'performa_date', title: 'Performa Date' },
                        { data: 'companyname', title: 'Company Name' },
                        { data: 'category_of_service', title: 'Service' },
                        { data: 'department', title: 'Department' },
                        { data: 'plant', title: 'Plant' },
                        { data: 'work_period', title: 'Work Period' },
                        {
                            data: 'po_no',
                            title: 'PO No',
                            defaultContent: '',
                            render: function(data, type, row) {
                                return data ? data : '';
                            }
                        },
                        {
                            data: 'po_date',
                            title: 'PO Date',
                            defaultContent: '',
                            render: function(data, type, row) {
                                return data ? data : '';
                            }
                        },
                        {
                            data: null,
                            title: 'Invoice No',
                            render: function(data, type, row) {
                                    return `${data.invoice_no}/00${data.id}`;
                                }
                        },
                        { data: 'invoice_date', title: 'Invoice Date' },
                        { data: 'total', title: 'Amount Without GST' },
                        { data: 'gst_amount', title: 'Amount GST' }  // Corrected data field
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: 'Copy',
                            title: 'Ambika Enterprise',
                            customize: function (data) {
                                var grandTotal = calculateGrandTotal(dataTable);
                                var gstGrandTotal = calculateGSTGrandTotal(dataTable);
                                data = data + '\n\nGrand Total: ' + grandTotal + '\nGST Grand Total: ' + gstGrandTotal;
                                return data;
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            title: 'Ambika Enterprise',
                            customize: function (csv) {
                                var grandTotal = calculateGrandTotal(dataTable);
                                var gstGrandTotal = calculateGSTGrandTotal(dataTable);
                                var csvData = csv.split('\n');
                                csvData.push('Grand Total,' + grandTotal, 'GST Grand Total,' + gstGrandTotal);
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
                                var gstGrandTotal = calculateGSTGrandTotal(dataTable);
                                var lastRow = $('row', sheet).last();
                                var lastRowIndex = parseInt(lastRow.attr('r')) + 1;

                                // Construct the new row for grand total
                                var newRow = `
                                    <row r="${lastRowIndex}">
                                        <c t="inlineStr" r="A${lastRowIndex}">
                                            <is><t>Grand Total</t></is>
                                        </c>
                                        <c t="n" r="B${lastRowIndex}">
                                            <v>${grandTotal}</v>
                                        </c>
                                    </row>`;

                                // Construct the new row for GST grand total
                                var newRowGST = `
                                    <row r="${lastRowIndex + 1}">
                                        <c t="inlineStr" r="A${lastRowIndex + 1}">
                                            <is><t>GST Grand Total</t></is>
                                        </c>
                                        <c t="n" r="B${lastRowIndex + 1}">
                                            <v>${gstGrandTotal}</v>
                                        </c>
                                    </row>`;

                                // Append new rows to the Excel sheet
                                sheet.childNodes[0].childNodes[1].innerHTML += newRow;
                                sheet.childNodes[0].childNodes[1].innerHTML += newRowGST;
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Ambika Enterprise',
                            customize: function (win) {
                                var grandTotal = calculateGrandTotal(dataTable);
                                var gstGrandTotal = calculateGSTGrandTotal(dataTable);
                                var content = '<div style="text-align: right; font-size: 1.2em;">' +
                                                '<strong>Grand Total: ' + grandTotal + '</strong><br>' +
                                                '<strong>GST Grand Total: ' + gstGrandTotal + '</strong>' +
                                            '</div>';
                                $(win.document.body).append(content);
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

                        // GST Total
                        var gstGrandTotal = data.reduce(function(acc, curr) {
                            return acc + parseFloat(curr.gst_amount);
                        }, 0).toFixed(2);

                        // Remove existing grand total row if present
                        $('#invoice-performa-list tfoot').remove();

                        // Add grand total row
                        var grandTotalRow = '<tfoot><tr><td colspan="11" style="text-align: right;"><strong>Grand Total:</strong></td><td>' + grandTotal + '</td><td>' + gstGrandTotal + '</td></tr></tfoot>';
                        $('#invoice-performa-list').append(grandTotalRow);
                    }
                });

                function calculateGrandTotal(dataTable) {
                    var data = dataTable.rows({ page: 'current' }).data().toArray();
                    return data.reduce(function(acc, curr) {
                        return acc + parseFloat(curr.total);
                    }, 0).toFixed(2);
                }
                function calculateGSTGrandTotal(data) {
                    var data = dataTable.rows({ page: 'current' }).data().toArray();
                    return data.reduce(function(acc, curr) {
                        return acc + parseFloat(curr.gst_amount);
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
