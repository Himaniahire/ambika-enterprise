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
                                @error('invoice_date')
                                    <li class="text-danger">{{ $message }}</li>
                                @enderror
                            </ul>
                        </div>
                    @endif
                    <table id="invPenTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Invoice Date</th>
                                <th>Invoice No</th>
                                <th>Summary No</th>
                                <th>Performa No</th>
                                <th>Total QTY</th>
                                <th>Total Rs.</th>
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
                                <th>Total QTY</th>
                                <th>Total Rs.</th>
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
    $(document).ready(function() {
    var table = $('#invPenTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:"{{ route('invoice-pending.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'company_name', name: 'register_companies.companyname' },
            { data: 'invoice_date', name: 'summaries.invoice_date', defaultContent: 'N/A' },
            { data: 'invoice_no', name: 'summaries.invoice_no', defaultContent: 'N/A' },
            { data: 'sum_no', name: 'summaries.sum_no' },
            { data: 'performa_no', name: 'summaries.performa_no' },
            { data: 'total', name: 'summaries.total' },
            { data: 'gst_amount', name: 'summaries.gst_amount' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        drawCallback: function(settings) {
            feather.replace(); // Replace icons using Feather icons
        }
    });

    // Handle modal and form submissions dynamically within the table
    $('#invoiceTable').on('click', '.btn-soft-primary', function(e) {
        e.preventDefault();
        var button = $(this);

        if (button.data('bs-toggle') === 'modal') {
            var targetModal = button.data('bs-target');
            $(targetModal).modal('show');
        }
    });

    // Date picker initialization if needed
    // $('.form-control[type="text"]').datepicker({
    //     format: 'dd-mm-yyyy',
    //     autoclose: true,
    //     todayHighlight: true
    // });
});

</script>


@endsection
