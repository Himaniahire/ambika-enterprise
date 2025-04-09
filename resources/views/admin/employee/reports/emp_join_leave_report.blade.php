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
                                Employee Join/Leave Report
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
                        <div class="card-header">Employee Join/Leave Report</div>
                        <div class="card-body">
                            <form action="" method="" id="emp-report-form" class="mb-3">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Employee Name</label>
                                        <select class="form-control" id="id" name="id" required>
                                            <option value="">Select Employee Name</option>
                                            <option value="">All Employee Name</option>
                                            @foreach ($employee as $item)
                                                <option value="{{ $item->id }}">{{ $item->first_name }} {{ $item->father_name }} {{ $item->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </form>
                            <table id="empJoinLeave" class="mt-3"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

@endsection

@section('footer-script')

<script>
    // $(document).ready(function() {
    //     var months = [
    //         { value: '01', name: 'January' },
    //         { value: '02', name: 'February' },
    //         { value: '03', name: 'March' },
    //         { value: '04', name: 'April' },
    //         { value: '05', name: 'May' },
    //         { value: '06', name: 'June' },
    //         { value: '07', name: 'July' },
    //         { value: '08', name: 'August' },
    //         { value: '09', name: 'September' },
    //         { value: '10', name: 'October' },
    //         { value: '11', name: 'November' },
    //         { value: '12', name: 'December' }
    //     ];

    //     $.each(months, function(index, month) {
    //         $('#monthDropdown').append($('<option>', {
    //             value: month.value,
    //             text: month.name
    //         }));
    //     });

    //     var startYear = 2023;
    //     var endYear = new Date().getFullYear();
    //     for (var year = startYear; year <= endYear; year++) {
    //         $('#yearDropdown').append($('<option>', {
    //             value: year,
    //             text: year
    //         }));
    //     }
    // });

    $(document).ready(function() {
    $('#emp-report-form').on('submit', function(e) {
        e.preventDefault();

        let employeeId = $('#id').val();

        // Perform the AJAX request only if an employee is selected or "All Employee Name" is selected
        $.ajax({
            url: "{{ route('reports.fetch_join_leave_report') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: employeeId // Can be empty for "All Employee Name"
            },
            success: function(response) {
                // Initialize DataTable with dynamic data
                $('#empJoinLeave').DataTable({
                    data: response.data, // Use the fetched data
                    destroy: true, // Destroy the previous instance of DataTable
                    columns: [
                        {
                            title: 'Employee Name',
                            data: null, // Since we're combining fields, set data to null
                            render: function(data, type, row) {
                                // Concatenate first_name, father_name, and last_name
                                return data.first_name + ' ' + data.father_name + ' ' + data.last_name;
                            }
                        },
                        { title: 'Date of Joining', data: 'date_of_joining', defaultContent: 'N/A' }, // Date of Joining column
                        { title: 'Leave Date', data: 'leave_date', defaultContent: 'N/A' } // Leave Date column
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            title: 'Employee Join & Leave Report',
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Employee Join & Leave Report',
                        },
                        {
                            extend: 'print',
                            title: 'Employee Join & Leave Report',
                        }
                    ],
                });
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});









</script>

@endsection
