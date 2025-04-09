@extends('admin.layouts.layout')
@section('content')

<style>
    @media (min-width: 1500px) {
    .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 1661px;
    }
}
</style>
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                                Employee Salary Report
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content -->
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Account details card -->
                    <div class="card mb-4">
                        <div class="card-header">Employee Salary Report</div>
                        <div class="card-body">
                            <form action="" method="" id="emp-report-form" class="mb-3">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Start Date</label>
                                        <input type="month" class="form-control" name="start_date" id="start_date">
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">End Date</label>
                                        <input type="month" class="form-control" name="end_date" id="end_date">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </form>
                            <table id="empSalary" class="table mt-3">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

@endsection

@section('footer-script')

<script>

$(document).ready(function () {
    $('#emp-report-form').on('submit', function(e) {
        e.preventDefault();

        // Capture start and end date from the form
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        var dataTable = $('#empSalary').DataTable({
            processing: true,
            serverSide: true,
            destroy: true, // Reinitialize the table when new data is fetched
            ajax: {
                url: '{{ route('reports.fetch_emp_salary_report') }}',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF token
                    start_date: startDate,
                    end_date: endDate
                },
                error: function(xhr, error, thrown) {
                    console.log(xhr.responseText);
                }
            },
            columns: [
                { data: 'employee_name', name: 'employee_name', title: 'Employee Name' },
                { data: 'deduct_advance', name: 'deduct_advance', title: 'Deduct Advance' },
                { data: 'total_present', name: 'total_present', title: 'Total Present' },
                { data: 'total_leave', name: 'total_leave', title: 'Total Leave' },
                { data: 'total_ot', name: 'total_ot', title: 'Total OT' },
                { data: 'salary', name: 'salary', title: 'Salary' },
                { data: 'additional_amount', name: 'additional_amount', title: 'Additional Amount' },
                { data: 'total_salary', name: 'total_salary', title: 'Total Salary' }
            ],

            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Employee Salaries',
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Employee Salaries',
                },
                {
                    extend: 'print',
                    title: 'Employee Salaries',
                }
            ]
        });
    });
});








</script>

@endsection
