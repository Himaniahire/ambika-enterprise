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
                                Employee Post List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-primary" href="{{ route('employee_posts.create') }}">
                                <i class="me-1" data-feather="user-plus"></i>
                                Add New Employee Post
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
                    <table id="empPostTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Category</th>
                                <th>Employee Post</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Category</th>
                                <th>Employee Post</th>
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
    $('#empPostTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee_posts.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'employee_category', name: 'getEmployeeCategory.emp_category' },
            { data: 'emp_post', name: 'emp_post' },
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
