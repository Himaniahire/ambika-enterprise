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
                                Performas List
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
                                @error('performa_date')
                                    <li class="text-danger">{{ $message }}</li>
                                @enderror
                            </ul>
                        </div>
                    @endif
                    <table id="performaTable" style="font-size: 14px;">
                        <thead>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select id="statusFilter" class="form-select">
                                        <option value="">All</option>
                                        <option value="Complete">Complete</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Cancel">Cancel</option>
                                    </select>
                                </div>
                            </div>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Performa Date</th>
                                <th>Performa No</th>
                                <th>Summary No</th>
                                <th>Invoice No</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Performa Date</th>
                                <th>Performa No</th>
                                <th>Summary No</th>
                                <th>Invoice No</th>
                                <th>Total</th>
                                <th>Status</th>
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
    $(document).ready(function() {
        // $('#performaTable').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     lengthChange: false,
        //     ajax: '{{ route('performa.index') }}',
        //     columns: [
        //         { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, },
        //         { data: 'company_name', name: 'getCompany.companyname', orderable: false },
        //         { data: 'performa_date', name: 'performa_date', orderable: false },
        //         { data: 'performa_no', name: 'performa_no', orderable: false },
        //         { data: 'sum_no', name: 'sum_no', orderable: false },
        //         { data: 'invoice_no', name: 'invoice_no', orderable: false },
        //         { data: 'gst_amount', name: 'gst_amount', orderable: false },
        //         { data: 'performa_status', name: 'performa_status', orderable: false }, // Hidden column
        //         { data: 'action', name: 'action', orderable: false, searchable: false }
        //     ],
        //     drawCallback: function(settings) {
        //             feather.replace(); // Re-initialize Feather icons
        //     },
        //     order: [[1, 'asc']], // Sort by the companyname column by default
        // });

        $('#statusFilter').change(function() {
            var status = $(this).val();

            $('#performaTable').DataTable().ajax.reload();
        });

        $('#performaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('performa.index') }}',
                data: function(d) {
                    d.performa_status = $('#statusFilter').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'company_name', name: 'getCompany.companyname', orderable: false },
                { data: 'performa_date', name: 'performa_date', orderable: false },
                { data: 'performa_no', name: 'performa_no', orderable: false },
                { data: 'sum_no', name: 'sum_no', orderable: false },
                { data: 'invoice_no', name: 'invoice_no', orderable: false },
                { data: 'gst_amount', name: 'gst_amount', orderable: false },
                { data: 'status', name: 'status', orderable: false },
                { data: 'performa_status', name: 'performa_status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            drawCallback: function(settings) {
                feather.replace(); // Re-initialize Feather icons
            },
            order: [[1, 'asc']], // Sort by the companyname column by default
        });

    });


</script>

@endsection
