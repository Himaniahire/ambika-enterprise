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
                            Employee Advance Salary
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                            <i class="me-1" data-feather="plus"></i>
                            Add New Employee Advance Salary
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <table id="salaryAdvTable">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Employee Name</th>
                            <th>Employee Advance Salary Date</th>
                            <th>Employee Advance Salary</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Employee Name</th>
                            <th>Employee Advance Salary Date</th>
                            <th>Employee Advance Salary</th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>

    <!-- Create group modal-->
    <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">Create New Advance Salary</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employee_advance_salary.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-1 small" for="emp_id">Employee Name <span class="text-danger">*</span></label>
                            <select class="form-control" name="emp_id" id="emp_id" required>
                                <option value="" disabled selected>Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->father_name}} {{$employee->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="mb-1 small" for="advance_date">Advance Date <span class="text-danger">*</span></label>
                            <input class="form-control" id="advance_date" name="advance_date" type="date" placeholder="Enter Advance Date..." required />
                        </div>

                        <div class="mb-3">
                            <label class="mb-1 small" for="advance_amount">Advance Amount <span class="text-danger">*</span></label>
                            <input class="form-control" id="advance_amount" name="advance_amount" type="number" step="0.01" placeholder="Enter Advance Amount..." required />
                        </div>
                        <button class="btn btn-primary" type="submit">Create New Advance Salary</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</main>
@endsection

@section('footer-script')

<script>
$(document).ready(function() {
    $('#salaryAdvTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee_advance_salary.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'employee_name', name: 'employee_name' },
            { data: 'advance_date', name: 'advance_date' },
            { data: 'advance_amount', name: 'advance_amount' }
            // Uncomment and add action column if needed
            // { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        drawCallback: function(settings) {
                feather.replace(); // Re-initialize Feather icons
        },
        order: [[1, 'asc']], // Sort by the companyname column by default
    });
});
</script>

@endsection
