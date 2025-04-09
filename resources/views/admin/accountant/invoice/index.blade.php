@extends('admin.layouts.layout')
@section('content')

<style>

    table.dataTable > thead > tr > th{
        border-bottom: 1px solid rgb(0 0 0);
    }

    table.dataTable > tfoot > tr > th{
        border-top: 0;
    }

    .dataTables_wrapper .dataTables_filter {
        padding-bottom: 20px;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding-top: 0.70em;
    }

    table.dataTable tbody td {
        padding: 8px 10px;
        border-bottom: solid 1px black;
    }

    .dataTables_processing {
        display: none !important;
    }

</style>
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Invoice List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @error('invoice_id')
                                    <li class="text-danger">{{ $message }}</li>
                                @enderror
                            </ul>
                        </div>
                    @endif
                    <table id="invTable">
                        <thead>
                            <div class="row">
                                <div class="col-md-3">
                                    <select id="statusFilter" class="form-select">
                                        <option value="">All</option>
                                        <option value="Complete">Complete</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Cancel">Cancel</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="perInvNo" class="form-select">
                                        <option value="">All</option>
                                        <option value="Performa">Performa</option>
                                        <option value="Invoice" selected>Invoice</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    {{-- <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        &nbsp;
                                        <span></span>
                                    </div> --}}
                                </div>
                                <div class="col-md-3" style="text-decoration: none; text-align: end; color: blue;">
                                    <button  id="resetFilters" class="btn btn-info">Reset</button>
                                </div>
                            </div>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Invoice Date</th>
                                <th>Invoice No</th>
                                <th>Summary No</th>
                                <th>Performa No</th>
                                <th>PO No</th>
                                <th>Total QTY</th>
                                <th>Total Rs.</th>
                                <th>Payment Status</th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Invoice Date</th>
                                <th>Invoice No</th>
                                <th>Summary No</th>
                                <th>Performa No</th>
                                <th>PO No</th>
                                <th>Total QTY</th>
                                <th>Total Rs.</th>
                                <th>Payment Status</th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('footer-script')

<script>
    // $(document).ready(function() {
    //     var table = $('#invTable').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         lengthChange: false,
    //         ajax: {
    //             url: "{{ route('invoice.index') }}",
    //             data: function(d) {
    //                 d.invoice_status = $('#statusFilter').val(); // Existing filter
    //                 d.per_inv_filter = $('#perInvNo').val(); // New filter
    //             }
    //         },
    //         columns: [
    //             { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
    //             { data: 'company_name', name: 'getCompany.companyname', orderable: false },
    //             { data: 'invoice_date', name: 'invoice_date', defaultContent: 'N/A', orderable: false },
    //             { data: 'invoice_no', name: 'invoice_no', defaultContent: 'N/A', orderable: false },
    //             { data: 'sum_no', name: 'sum_no', orderable: false },
    //             { data: 'performa_no', name: 'performa_no', orderable: false },
    //             { data: 'po_no', name: 'po_no', orderable: false },
    //             { data: 'total', name: 'total', orderable: false },
    //             { data: 'gst_amount', name: 'gst_amount', orderable: false },
    //             { data: 'status', name: 'status', orderable: false },
    //             { data: 'invoice_status', name: 'invoice_status', orderable: false },
    //             { data: 'action', name: 'action', orderable: false, searchable: false },
    //         ],
    //         drawCallback: function(settings) {
    //             feather.replace(); // Re-initialize Feather icons
    //         },
    //         order: [[1, 'asc']], // Default order by company_name
    //     });

    //     // Refresh DataTable when filters change
    //     $('#statusFilter, #perInvNo').change(function() {
    //         table.ajax.reload();
    //     });
    // });

    // $(function() {

    //     var start = moment().subtract(29, 'days');
    //     var end = moment();

    //     function cb(start, end) {
    //         $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    //     }

    //     $('#reportrange').daterangepicker({
    //         startDate: start,
    //         endDate: end,
    //         ranges: {
    //         'Today': [moment(), moment()],
    //         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //         'This Month': [moment().startOf('month'), moment().endOf('month')],
    //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //         }
    //     }, cb);

    //     cb(start, end);

    // });


    $(document).ready(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        // function setDateRangePicker(start, end) {
        //     $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        // }

        // setDateRangePicker(start, end);

        var table = $('#invTable').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            ajax: {
                url: "{{ route('invoice.index') }}",
                data: function(d) {
                    d.invoice_status = $('#statusFilter').val();
                    d.per_inv_filter = $('#perInvNo').val();
                    // d.start_date = start.format('YYYY-MM-DD');
                    // d.end_date = end.format('YYYY-MM-DD');
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'company_name', name: 'getCompany.companyname', orderable: false },
                { data: 'invoice_date', name: 'invoice_date', defaultContent: 'N/A', orderable: false },
                { data: 'invoice_no', name: 'invoice_no', defaultContent: 'N/A', orderable: false },
                { data: 'sum_no', name: 'sum_no', orderable: false },
                { data: 'performa_no', name: 'performa_no', orderable: false },
                { data: 'po_no', name: 'po_no', orderable: false },
                { data: 'total', name: 'total', orderable: false },
                { data: 'gst_amount', name: 'gst_amount', orderable: false },
                { data: 'status', name: 'status', orderable: false },
                { data: 'invoice_status', name: 'invoice_status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            drawCallback: function(settings) {
                feather.replace();
            },
            order: [[1, 'asc']],
        });

        // // Initialize Date Range Picker
        // $('#reportrange').daterangepicker({
        //     startDate: start,
        //     endDate: end,
        //     ranges: {
        //         'Today': [moment(), moment()],
        //         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //         'This Month': [moment().startOf('month'), moment().endOf('month')],
        //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //     }
        // },
        // function(startDate, endDate) {
        //     start = startDate;
        //     end = endDate;
        //     setDateRangePicker(start, end);
        //     table.ajax.reload(null, false);
        // });

        // Refresh DataTable when filters change
        $('#statusFilter, #perInvNo').change(function() {
            table.ajax.reload(null, false);
        });

        // Reset Filters Functionality
        $('#resetFilters').click(function() {
            $('#statusFilter').val('').trigger('change');
            $('#perInvNo').val('').trigger('change');

            start = moment().subtract(29, 'days');
            end = moment();

            // Destroy existing DatePicker instance before resetting
            $('#reportrange').daterangepicker('destroy');

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));

            table.ajax.reload(null, false);
        });
    });


</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@endsection
