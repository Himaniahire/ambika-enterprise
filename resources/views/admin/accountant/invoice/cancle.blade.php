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
                    <table id="invTableCan">
                        <thead>
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
        $('#invTableCan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('invoice.cancel') }}",
                type: 'GET',
                error: function(xhr, error, thrown) {
                    console.error('AJAX Error:', error, thrown);
                    console.error('Response:', xhr.responseText);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'company_name', name: 'getCompany.companyname' },
                { data: 'invoice_date', name: 'invoice_date', defaultContent: 'N/A' },
                { data: 'invoice_no', name: 'invoice_no', defaultContent: 'N/A' },
                { data: 'sum_no', name: 'sum_no' },
                { data: 'performa_no', name: 'performa_no' },
                { data: 'po_no', name: 'po_no' },
                { data: 'total', name: 'total' },
                { data: 'gst_amount', name: 'gst_amount' },
            ],
            drawCallback: function(settings) {
                feather.replace(); // Re-initialize Feather icons
            },
            order: [[1, 'asc']], // Default order by company_name
        });
    });
</script>

@endsection
