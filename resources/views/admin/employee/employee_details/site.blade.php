@extends('admin.layouts.layout')
@section('content')
<style>
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
                                Site Employee Detail List
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
                    <table id="empSiteTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Phone No.</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Phone No.</th>
                                <th>Status</th>
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
        $('#empSiteTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employee_details.site') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'employee_name', name: 'employee_name' },
                { data: 'emp_code', name: 'emp_code' },
                { data: 'phone_no', name: 'phone_no' },
                { data: 'status', name: 'status' },
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
