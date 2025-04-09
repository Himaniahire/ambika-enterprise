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
                                Employee Attendance List
                            </h1>
                        </div>
                        {{-- <div class="col-12 col-xl-auto mb-3 d-flex">
                            <div class="col-6 col-md-6" style="margin-right: 10px;">
                                <label class="small mb-1" for="inputFirstName">Start Date</label>
                                <input class="form-control" id="start_date" type="date" name="start_date"
                                    value="" />
                            </div>
                            <div class="col-6 col-md-6" id="inputContainer">
                                <label class="small mb-1" for="inputFirstName">End Date</label>
                                <input class="form-control" type="date" name="end_date" id="end_date"
                                    value="" />
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    <table id="employeeAttendanceTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Company Name</th>
                                <th>Attendance Date</th>
                                <th>Attendance Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Company Name</th>
                                <th>Attendance Date</th>
                                <th>Attendance Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>


@endsection

@section('footer-script')

<!--Import jQuery before export.js-->



<script type="text/javascript">

$(document).ready(function() {
    $('#employeeAttendanceTable').DataTable({
        processing: false,
        serverSide: true,
        pageLength: 10, // Show only 10 entries per page
        lengthMenu: [10, 25, 50, 100], // Pagination options
        ajax: "{{ route('employee_attendance.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // ✅ Fix applied
            { data: 'employee_name', name: 'employee_name' },
            { data: 'emp_code', name: 'emp_code' },
            { data: 'company_name', name: 'company_name' },
            { data: 'attendance_date', name: 'attendance_date' },
            { data: 'status', name: 'status', orderable: false, searchable: false } // Ensure proper sorting
        ]
    });
});



</script>





@endsection
