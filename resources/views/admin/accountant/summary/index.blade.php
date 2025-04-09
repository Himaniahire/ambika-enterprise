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
                                Summary List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-primary" href="{{ route('summary.create') }}">
                                <i class="me-1" data-feather="user-plus"></i>
                                Add New Summary
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    <table id="sumTable" >
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Summary Duration</th>
                                <th>Summary No</th>
                                <th>Performa No</th>
                                <th>Invoice No</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Summary Duration</th>
                                <th>Summary No</th>
                                <th>Performa No</th>
                                <th>Invoice No</th>
                                <th>Total</th>
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
    $('#sumTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('summary.index') }}",
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'companyname', name: 'companyname' },
            { data: 'summ_date', name: 'summ_date' },
            { data: 'sum_no', name: 'sum_no' },
            { data: 'performa_no', name: 'performa_no' },
            { data: 'invoice_no', name: 'invoice_no' },
            { data: 'total', name: 'total' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        drawCallback: function(settings) {
            feather.replace(); // Re-initialize Feather icons
        },
        order: [[1, 'asc']], // Sort by the companyname column by default
        rowCallback: function(row, data, index) {
            var pageInfo = $('#sumTable').DataTable().page.info();
            $('td:eq(0)', row).html(pageInfo.start + index + 1);
        }
    });
});




</script>

@endsection
