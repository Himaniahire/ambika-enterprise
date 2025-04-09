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
                    <table id="activityTable">
                        <thead>
                            {{-- <select id="statusFilter" class="form-select" style="width: 110px;padding: 10px;margin-bottom: -17px;">
                                <option value="">All</option>
                                <option value="Complete">Complete</option>
                                <option value="Pending">Pending</option>
                                <option value="Cancel">Cancel</option>
                            </select> --}}
                            <tr>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Entity</th>
                                    <th>Entity ID</th>
                                    <th>Details</th>
                                    <th>Date</th>
                                </tr>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Entity</th>
                                    <th>Entity ID</th>
                                    <th>Details</th>
                                    <th>Date</th>
                                </tr>
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
    $('#activityTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('activity_log.index') }}",
        columns: [
            { data: 'full_name', name: 'full_name' },  // User Name from Join
            { data: 'action', name: 'activity_log.action' },
            { data: 'entity', name: 'activity_log.entity' },
            { data: 'entity_id', name: 'activity_log.entity_id' },
            { data: 'details', name: 'activity_log.details' },
            { data: 'created_at', name: 'activity_log.created_at' }
        ]
    });
});

</script>

@endsection
