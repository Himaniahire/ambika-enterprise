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
                                <div class="col-md-3">
                                    <div id="reportrange"
                                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        &nbsp;
                                        <span></span>
                                    </div>
                                </div>
                                <div class="col-md-3" style="text-decoration: none; text-align: end; color: blue;">
                                    <button id="resetFilters" class="btn btn-info">Reset</button>
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
                                <th colspan="6" style="text-align:right">Total GST:</th>
                                <th id="totalGstAmount"></th>
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


    $(document).ready(function () {
        let table;

        // Initialize Date Range Picker
        function setDateRangePicker() {
            const $range = $('#reportrange');

            $range.find('span').html('MM/DD/YYYY - MM/DD/YYYY');

            $range.daterangepicker({
                autoUpdateInput: false,
                alwaysShowCalendars: true,
                opens: 'center',
                autoApply: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function (start, end) {
                if (moment.isMoment(start) && moment.isMoment(end)) {
                    $range.find('span').html(`${start.format('MMMM D, YYYY')} - ${end.format('MMMM D, YYYY')}`);
                    window.dateRange = { start, end };
                    table.ajax.reload(null, false);
                }
            });

            // Cancel event to clear range
            $range.on('cancel.daterangepicker', function () {
                $(this).find('span').html('MM/DD/YYYY - MM/DD/YYYY');
                window.dateRange = { start: null, end: null };
                table.ajax.reload(null, false);
            });

            // Initialize empty range
            window.dateRange = { start: null, end: null };
        }

        // Call date picker setup
        setDateRangePicker();

        // Initialize DataTable
        table = $('#performaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('performa.index') }}",
                data: function (d) {
                    d.performa_status = $('#statusFilter').val();

                    if (window.dateRange.start && window.dateRange.end) {
                        d.start_date = window.dateRange.start.format('YYYY-MM-DD');
                        d.end_date = window.dateRange.end.format('YYYY-MM-DD');
                    }
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
            drawCallback: function () {
                feather.replace(); // Optional: Replace feather icons
            },
            order: [[1, 'asc']]
        });
        
        $('#performaTable').on('xhr.dt', function (e, settings, json, xhr) {
            $('#totalGstAmount').html(json.total_gst_amount);
        });

        // Filter change triggers
        $('#statusFilter').on('change', function () {
            table.ajax.reload(null, false);
        });

        // Reset filters and date range
        $('#resetFilters').on('click', function () {
            $('#statusFilter').val('').trigger('change');

            $('#reportrange span').html('MM/DD/YYYY - MM/DD/YYYY');
            window.dateRange = { start: null, end: null };

            const picker = $('#reportrange').data('daterangepicker');
            if (picker) {
                picker.setStartDate(moment());
                picker.setEndDate(moment());
                picker.hide(); // Optionally close the picker
            }

            table.ajax.reload(null, false);
        });
    });

    </script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@endsection
