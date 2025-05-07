@extends('admin.layouts.layout')
@section('content')

<style>
    @media (min-width: 1500px) {
    .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 1661px;
    }
}
</style>
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                                Pending Perform Report
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
                        <div class="card-header">Pending Perform Report</div>
                        <div class="card-body">
                            <form action="" method="" id="report-form">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Company Name</label>
                                        <select class="form-control" id="company_id" name="company_id" required>
                                            <option value="">Select Company Name</option>
                                            <option value="">All Company Name</option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                            @endforeach
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
                                    <div class="col-6 col-md-4" id="inputContainer">
                                        <label class="small mb-1" for="inputFirstName">Month</label>
                                        <input class="form-control" type="month" name="month" id="month"
                                            value="" />
                                    </div>
                                    <div class="col-6 col-md-4" id="inputContainer">
                                        <label class="small mb-1" for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="All">All</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Cancel">Cancel</option>
                                        </select>
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
                        <div class="card-header">Pending Perform Report</div>
                        <div class="card-body" style="padding: 17px 6px 17px 6px;">
                            <table id="reportTable"></table>
                        </div>
                        <div class="card-body" style="padding: 17px 6px 17px 6px;">
                            <table id="reportPOTable"></table>
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

// $('#company_id').change(function() {
//     var companyId = $(this).val();
//     $.ajax({
//         url: "{{ route('purchase-orders', ['companyId']) }}".replace('companyId', companyId),
//         type: 'GET',
//         success: function(response) {
//             var purchaseOrders = response.purchaseOrders;
//             if (purchaseOrders.length > 0) {
//                 // Display the purchase order dropdown
//                 $('.poSelect').empty().show().append('<option value="">Select Purchase Order</option>');
//                 purchaseOrders.forEach(function(po) {
//                     $('.poSelect').append('<option value="' + po.id + '">' + po.po_no + '</option>');
//                 });
//                 $('#noPoMessage').hide();
//             } else {
//                 // Clear and hide the product dropdown
//                 $('.poSelect').hide();
//                 $('#noPoMessage').show(); // Show the no purchase order message
//             }

//         }
//     });
// });

// $(document).ready(function() {
//     // Fetch and populate service codes when the company_id changes
//     $('#company_id').change(function() {
//         var companyId = $(this).val();
//         if (companyId) {
//             $.ajax({
//                 url: "{{ route('get.services', ':id') }}".replace(':id', companyId),
//                 type: 'GET',
//                 success: function(data) {
//                     $('.service_code_id').empty().append('<option value="">Select Company Service Code </option>');
//                     $.each(data, function(index, service) {
//                         $('.service_code_id').append('<option value="' + service.id + '">' + service.service_code + '</option>');
//                     });
//                 }
//             });
//         }
//     });

//     // Fetch and populate service codes when the poSelect changes
//     $('.poSelect').change(function() {
//         var poId = $(this).val();
//         if (poId) {
//             $.ajax({
//                 url: "{{ route('get-service', ':id') }}".replace(':id', poId),
//                 type: 'GET',
//                 success: function(data) {
//                     $('.service_code_id').empty().append('<option value="">Select PO Service Code</option>');
//                     $.each(data, function(index, service) {
//                         $('.service_code_id').append('<option value="' + service.id + '">' + service.service_code + '</option>');
//                     });
//                 }
//             });
//         }
//     });
// });

$(document).ready(function() {
    var dataTable;
    $('#report-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var companyId = $('#company_id').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var month = $('#month').val();
        var status = $('#status').val();

        $.ajax({
            url: '{{ route("fetch.data.company.inv") }}',
            method: 'POST',
            data: {
                company_id: companyId,
                start_date: startDate,
                end_date: endDate,
                month: month,
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token from meta tag
            },
            success: function(response) {
                var summaries = response.summaries;

                if (dataTable) {
                    dataTable.destroy();
                }

                var columns = [
                    { data: 'companyname', title: 'Company Name', defaultContent: 'N/A' },
                    { data: 'sum_no', title: 'Sum No', defaultContent: 'N/A' },
                    { data: 'performa_date', title: 'Performa Date', defaultContent: 'N/A' },
                    { data: 'invoice_no', title: 'Invoice No', defaultContent: 'N/A' },
                    { data: 'performa_no', title: 'Performa No', defaultContent: 'N/A' },
                    { data: 'po_no', title: 'PO No', defaultContent: 'N/A', width: '100px' },
                    { data: 'total', title: 'PO Total', defaultContent: 'N/A' },
                    { data: 'price_total', title: 'Amount without Tax', defaultContent: 'N/A' },
                    { data: 'gst_amount', title: 'Amount With Tax', defaultContent: 'N/A' }
                ];

                dataTable = $('#reportTable').DataTable({
                    data: summaries,
                    columns: columns,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            title: 'Pending Performa',
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml']; // Access the Excel sheet

                                var allRows = dataTable.rows().data(); // Fetch all rows' data

                                // Function to calculate the grand total of price_total
                                function calculateGrandTotal(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.price_total || 0); // Sum price_total values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }

                                // Function to calculate the grand total of gst_amount
                                function calculateGrandGSTTotal(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.gst_amount || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }

                                // Calculate totals for all rows
                                var grandTotal = calculateGrandTotal(allRows);
                                var grandGSTTotal = calculateGrandGSTTotal(allRows);
                                var rowCount = allRows.length;

                                // Append totals at the end of the Excel file
                                var lastRow = `<row><c t="inlineStr"><is><t></t></is></c><c t="inlineStr"><is><t></t></is></c><c t="inlineStr"><is><t>Amount: ${grandTotal}</t></is></c><c t="inlineStr"><is><t>GST Amount: ${grandGSTTotal}</t></is></c><c t="inlineStr"><is><t>Bill Count: ${rowCount}</t></is></c></row>`;

                                var sheetData = $(sheet).find('sheetData');
                                sheetData.append(lastRow); // Append the calculated row to the Excel data
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            title: 'Pending Performa',
                            customize: function(doc) {
                                var allRows = dataTable.rows().data(); // Fetch all rows' data

                                // Function to calculate the grand total of price_total
                                function calculateGrandTotal(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.price_total || 0); // Sum price_total values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }

                                // Function to calculate the grand total of gst_amount
                                function calculateGrandGSTTotal(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.gst_amount || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }

                                // Calculate totals for all rows
                                var grandTotal = calculateGrandTotal(allRows);
                                var grandGSTTotal = calculateGrandGSTTotal(allRows);
                                var rowCount = allRows.length;

                                // Append totals to the footer of the PDF
                                doc.content.push({
                                    table: {
                                        body: [
                                            ['', '', '', '', 'Amount: ' + grandTotal],
                                            ['', '', '', '', 'GST Amount: ' + grandGSTTotal],
                                            ['', '', '', '', 'Bill Count: ' + rowCount]
                                        ]
                                    },
                                    margin: [0, 0, 0, 30], // Adjust margins for footer placement
                                });
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            title: 'Pending Performa',
                            customize: function(win) {
                                // Get all the rows' data (including rows from all pages)
                                var allRows = dataTable.rows().data();

                                // Function to calculate the grand total of price_total
                                function calculateGrandTotal(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.price_total || 0); // Sum price_total values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }

                                // Function to calculate the grand total of gst_amount
                                function calculateGrandGSTTotal(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.gst_amount || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }

                                // Calculate totals for all rows
                                var grandTotal = calculateGrandTotal(allRows);
                                var grandGSTTotal = calculateGrandGSTTotal(allRows);
                                var rowCount = allRows.length; // Total number of rows in the entire table

                                // Append the calculated totals to the footer section
                                $(win.document.body).append(`
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><strong>Amount: </strong>${grandTotal}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><strong>GST Amount: </strong>${grandGSTTotal}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><strong>Bill Count: </strong>${rowCount}</td>
                                        </tr>
                                    </tfoot>
                                `);
                            }
                        }
                    ],
                    processing: true, // Enable processing indicator
                    serverSide: false, // Disable server-side processing if you handle data on the client-side
                    drawCallback: function(settings) {
                        var api = this.api();
                        var data = api.rows({ page: 'current' }).data();

                        var grandTotal = data.reduce(function(acc, curr) {
                            return acc + parseFloat(curr.price_total || 0);
                        }, 0).toFixed(2);

                        var grandGSTTotal = data.reduce(function(acc, curr) {
                            return acc + parseFloat(curr.gst_amount || 0);
                        }, 0).toFixed(2);

                        $('#reportTable tfoot').remove(); // Target the correct table

                        var grandTotalRow = '<tfoot><tr><td></td><td></td><td></td><td></td><td></td><td></td><td>Grand Total:</td><td>' + grandTotal + '</td><td>' + grandGSTTotal + '</td></tr></tfoot>';
                        $('#reportTable').append(grandTotalRow);

                        // Update row count display
                        var rowCount = api.rows().count();
                        $('#rowCountDisplay').text('Row Count: ' + rowCount);
                    }
                });
                function calculateGrandTotal(dataTable) {
                    var data = dataTable.rows({ page: 'current' }).data().toArray();
                    return data.reduce(function(acc, curr) {
                        return acc + parseFloat(curr.price_total || 0);
                    }, 0).toFixed(2);
                }

                function calculateGrandGSTTotal(dataTable) {
                    var data = dataTable.rows({ page: 'current' }).data().toArray();
                    return data.reduce(function(acc, curr) {
                        return acc + parseFloat(curr.gst_amount || 0);
                    }, 0).toFixed(2);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });
});

</script>


@endsection
