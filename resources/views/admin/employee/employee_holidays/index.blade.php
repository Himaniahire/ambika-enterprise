@extends('admin.layouts.layout')
@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Employee Holiday List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-primary" href="{{ route('employee_holidays.create') }}">
                                <i class="me-1" data-feather="user-plus"></i>
                                Add New Employee Holiday
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
                    <table id="holidayTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Holiday Date</th>
                                <th>Holiday Day</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Holiday Date</th>
                                <th>Holiday Day</th>
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
        $('#holidayTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employee_holidays.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'holiday_date', name: 'holiday_date' },
                { data: 'holiday', name: 'holiday' },
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
