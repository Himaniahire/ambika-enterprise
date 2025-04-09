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
                                Final Invoice Report
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
                        <div class="card-header">Final Invoice Report</div>
                        <div class="card-body">
                            <form action="" method="" id="filterForm">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    {{-- <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Company Name</label>
                                        <select class="form-control" id="company_id" name="company_id" required>
                                            <option value="">Select Company Name</option>
                                            <option value="">All Company Name</option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Start Date</label>
                                        <input class="form-control" id="start_date" type="date" name="start_date"
                                            value="" required />
                                    </div>
                                    <div class="col-6 col-md-4" id="inputContainer">
                                        <label class="small mb-1" for="inputFirstName">End Date</label>
                                        <input class="form-control" type="date" name="end_date" id="end_date"
                                            value="" required />
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
                        <div class="card-header">Final Report</div>
                        <div class="card-body" style="padding: 17px 6px 17px 6px;">
                            <table id="invoiceTable" class="display">

                            </table>

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

    // $(document).ready(function() {
    //     var table = $('#invoiceTable').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //             url: '{{ route('fetch.invoices') }}',
    //             method: 'POST',
    //             data: function (d) {
    //                 d._token = $('input[name="_token"]').val();
    //                 d.start_date = $('#start_date').val();
    //                 d.end_date = $('#end_date').val();
    //             },
    //             dataSrc: 'data'
    //         },
    //         columns: [
    //             { data: 'companyname', name: 'companyname', title: 'Company Name' },
    //             { data: 'invoice_no', name: 'invoice_no', title: 'Invoice No' },
    //             { data: 'invoice_date', name: 'invoice_date', title: 'Invoice Date' },
    //             { data: 'po_no', name: 'po_no', title: 'PO No' },
    //             { data: 'price_total', name: 'price_total', title: 'Amount' },
    //             { data: 'gst_amount', name: 'gst_amount', title: 'Amount (GST)' }
    //         ]
    //     });

    //     $('#filterForm').on('submit', function(e) {
    //         e.preventDefault();
    //         table.draw();
    //     });
    // });


    $(document).ready(function() {
        var dataTable;

        $('#filterForm').submit(function(e) {
            e.preventDefault();

            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            $.ajax({
                url: '{{ route("fetch.invoices") }}',
                method: 'POST',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    _token: $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token from meta tag
                },
                success: function(response) {
                    console.log(response); // Check response structure

                    var invoices = response.data; // Access 'data' key

                    if (dataTable) {
                        dataTable.destroy(); // Destroy the previous instance
                    }

                    dataTable = $('#invoiceTable').DataTable({
                        data: invoices,
                        columns: [
                            { data: 'companyname', name: 'companyname', title: 'Company Name', defaultContent: 'N/A'  },
                            { data: 'invoice_no', name: 'invoice_no', title: 'Invoice No', defaultContent: 'N/A'  },
                            { data: 'invoice_date', name: 'invoice_date', title: 'Invoice Date', defaultContent: 'N/A'  },
                            { data: 'po_no', name: 'po_no', title: 'PO No', defaultContent: 'N/A'  },
                            { data: 'price_total', name: 'price_total', title: 'Amount', defaultContent: 'N/A'  },
                            { data: 'gst_amount', name: 'gst_amount', title: 'Amount (GST)', defaultContent: 'N/A'  }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                title: 'Ambika Enterprise'
                            },
                            {
                                extend: 'pdfHtml5',
                                text: 'PDF',
                                title: 'Ambika Enterprise'
                            },
                            {
                                extend: 'print',
                                text: 'Print',
                                title: 'Ambika Enterprise'
                            }
                        ],
                        processing: true,
                        serverSide: false
                    });
                },
                error: function(xhr) {
                    // Provide user feedback in case of error
                    alert('An error occurred while fetching data. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        });
    });




</script>


@endsection
