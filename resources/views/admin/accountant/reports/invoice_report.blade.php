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
                                Invoice Payment Receive Report
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
                        <div class="card-header">Invoice Payment Receive Report</div>
                        <div class="card-body">
                            <form action="" method="" id="invoiceForm">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Company Name</label>
                                        <select class="form-control" id="company_id" name="company_id" required>
                                            <option value="">Select Company Name</option>
                                            <option value="">All Company Name</option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small  mb-1" for="inputFirstName">Invoice Status</label>
                                        <select class="form-control" id="invoice_status" name="invoice_status">
                                            <option value="">Select Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Complete">Complete</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Start Date</label>
                                        <input class="form-control" id="start_date" type="date" name="start_date"
                                            value="" required/>
                                    </div>
                                    <div class="col-6 col-md-3" id="inputContainer">
                                        <label class="small mb-1" for="inputFirstName">End Date</label>
                                        <input class="form-control" type="date" name="end_date" id="end_date"
                                            value="" required/>
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
                        <div class="card-header">Invoice Payment Receive Report</div>
                        <div class="card-body" style="padding: 17px 6px 17px 6px;">
                            <table id="invoiceTable"></table>
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

    $('#invoiceForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();

        var formObject = {};
        $.each(formData, function(_, field) {
            formObject[field.name] = field.value || null;
        });

        // Destroy the existing datatable if it exists
        if (dataTable) {
            dataTable.destroy();
        }

        // Initialize the new datatable with server-side processing
        dataTable = $('#invoiceTable').DataTable({
            ajax: {
                url: "{{ route('fetch.data.invoice') }}",
                type: 'POST',
                data: function(d) {
                    // Merge the form data with the datatable request
                    return $.extend({}, d, formObject);
                }
            },
            columns: [
                { data: 'companyname', title: 'Company Name', defaultContent: 'N/A' },
                { data: 'invoice_no', title: 'Invoice No', defaultContent: 'N/A' },
                { data: 'formatted_invoice_date', title: 'Invoice Date', defaultContent: 'N/A' },
                { data: 'formatted_payment_receive_date', title: 'Payment Receive Date', defaultContent: 'N/A' },
                { data: 'invoice_status', title: 'Invoice Status', defaultContent: 'N/A' },
                { data: 'price_total', title: 'Amount Without Tax', defaultContent: 'N/A' },
                { data: 'gst_amount', title: 'Amount With Tax', defaultContent: 'N/A' },
                { data: 'tds', title: 'TDS', defaultContent: 'N/A' },
                { data: 'retention', title: 'Retention', defaultContent: 'N/A' },
                { data: 'penalty', title: 'Penalty', defaultContent: 'N/A' },
                { data: 'payment', title: 'Payment', defaultContent: 'N/A' }
            ],
            dom: 'Bfrtip', // Include buttons and custom layout
            buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            title: 'Ambika Enterprise',
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
                                
                                // Function to calculate the grand total of gst_amount
                                function calculatetotalpenalty(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.penalty || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }
                                
                                // Function to calculate the grand total of gst_amount
                                function calculatetotalpayment(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.payment || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }
                        
                                // Calculate totals for all rows
                                var grandTotal = calculateGrandTotal(allRows);
                                var grandGSTTotal = calculateGrandGSTTotal(allRows);
                                var totalpenalty = calculatetotalpenalty(allRows);
                                var totalpayment = calculatetotalpayment(allRows);
                                var rowCount = allRows.length;
                        
                                // Append totals at the end of the Excel file
                                var lastRow = `<row>
                                                    <c t="inlineStr">
                                                        <is><t></t></is>
                                                    </c>
                                                    <c t="inlineStr">
                                                        <is><t></t></is>
                                                    </c>
                                                    <c t="inlineStr">
                                                        <is><t>Amount: ${grandTotal}</t></is>
                                                    </c>
                                                    <c t="inlineStr">
                                                        <is><t>GST Amount: ${grandGSTTotal}</t></is>
                                                    </c>
                                                    <c t="inlineStr">
                                                        <is><t>Total Penalty: ${totalpenalty}</t></is>
                                                    </c>
                                                    <c t="inlineStr">
                                                        <is><t>Total Payment: ${totalpayment}</t></is>
                                                    </c>
                                                    <c t="inlineStr">
                                                        <is><t>Bill Count: ${rowCount}</t></is>
                                                    </c>
                                               </row>`;
                        
                                var sheetData = $(sheet).find('sheetData');
                                sheetData.append(lastRow); // Append the calculated row to the Excel data
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            title: 'Ambika Enterprise',
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
                                
                                // Function to calculate the grand total of gst_amount
                                function calculatetotalpenalty(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.penalty || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }
                                
                                // Function to calculate the grand total of gst_amount
                                function calculatetotalpayment(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.payment || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }
                        
                                // Calculate totals for all rows
                                var grandTotal = calculateGrandTotal(allRows);
                                var grandGSTTotal = calculateGrandGSTTotal(allRows);
                                var totalpenalty = calculatetotalpenalty(allRows);
                                var totalpayment = calculatetotalpayment(allRows);
                                var rowCount = allRows.length;
                        
                                // Append totals to the footer of the PDF
                                doc.content.push({
                                    table: {
                                        body: [
                                            ['', '', '', '', 'Amount: ' + grandTotal],
                                            ['', '', '', '', 'GST Amount: ' + grandGSTTotal],
                                            ['', '', '', '', 'Total Penalty: ' + totalpenalty],
                                            ['', '', '', '', 'Total Payment: ' + totalpayment],
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
                            title: 'Ambika Enterprise',
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
                                
                                // Function to calculate the grand total of gst_amount
                                function calculatetotalpenalty(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.penalty || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }
                                
                                // Function to calculate the grand total of gst_amount
                                function calculatetotalpayment(rows) {
                                    return rows.reduce(function(total, row) {
                                        return total + parseFloat(row.penalty || 0); // Sum gst_amount values
                                    }, 0).toFixed(2); // Keep 2 decimal points
                                }
                            
                                // Calculate totals for all rows
                                var grandTotal = calculateGrandTotal(allRows);
                                var grandGSTTotal = calculateGrandGSTTotal(allRows);
                                var totalpenalty = calculatetotalpenalty(allRows);
                                var totalpayment = calculatetotalpayment(allRows);
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
                                            <td><strong>Total Penalty: </strong>${totalpenalty}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><strong>Total Payment: </strong>${totalpayment}</td>
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
            drawCallback: function(settings) {
                var api = this.api();
                var data = api.rows({ page: 'current' }).data();

                var grandTotal = data.reduce(function(acc, curr) {
                    return acc + parseFloat(curr.price_total || 0);
                }, 0).toFixed(2);

                var grandGSTTotal = data.reduce(function(acc, curr) {
                    return acc + parseFloat(curr.gst_amount || 0);
                }, 0).toFixed(2);

                var totalpenalty = data.reduce(function(acc, curr) {
                    return acc + parseFloat(curr.penalty || 0);
                }, 0).toFixed(2);
                
                var totalpayment = data.reduce(function(acc, curr) {
                    return acc + parseFloat(curr.payment || 0);
                }, 0).toFixed(2);

                $('#invoiceTable tfoot').remove(); // Target the correct table

                var grandTotalRow = '<tfoot><tr><td></td><td></td><td></td><td></td><td>Grand Total:</td><td>' + grandTotal + '</td><td>' + grandGSTTotal + '</td><td></td><td></td><td>' + totalpenalty + '</td><td>' + totalpayment + '</td></tr></tfoot>';
                $('#invoiceTable').append(grandTotalRow);

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

        function calculatetotalpenalty(dataTable) {
            var data = dataTable.rows({ page: 'current' }).data().toArray();
            return data.reduce(function(acc, curr) {
                return acc + parseFloat(curr.penalty || 0);
            }, 0).toFixed(2);
        }
        
        function calculatetotalpayment(dataTable) {
            var data = dataTable.rows({ page: 'current' }).data().toArray();
            return data.reduce(function(acc, curr) {
                return acc + parseFloat(curr.payment || 0);
            }, 0).toFixed(2);
        }
    });
});





</script>


@endsection
