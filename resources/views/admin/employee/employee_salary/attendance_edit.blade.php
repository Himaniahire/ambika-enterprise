@extends('admin.layouts.layout')
@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Add Employee Attendance
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content -->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-12">
                <!-- Account Attendances card -->
                <div class="card mb-4">
                    <div class="card-header">Employee Attendance</div>
                    <div class="card-body">
                        <form action="">
                            <div class="row gx-3 mb-3">
                                <div class="col-4 col-md-4">
                                    <label class="small mb-1" for="attendance_date">Attandance Date<span class="text-danger">*</span></label>
                                    <input class="form-control" id="attendance_date" type="date" name="attendance_date" value="" />
                                </div>
                                <div class="col-4 col-md-4">
                                    <label for="company_id">Company name <span class="text-danger">*</span></label>
                                    <select class="form-control" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $item)
                                            <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 col-md-4">
                                    <button type="button" id="fetchAttendanceBtn" class="btn btn-primary mt-3">Fetch Attendance</button>
                                </div>
                            </div>
                        </form>
                        <form id="attendanceForm" action="{{ route('employee_attendance.empupdate') }}" method="POST">
                            @csrf
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <input type="hidden" name="hidden_company_id" id="hidden_company_id" value="">
                                    <input type="hidden" class="form-control" name="hidden_attendance_date" id="hidden_attendance_date" value="">
                                </div>
                            </div>

                            <table id="myTable" class="mt-5">
                                <thead>
                                    <tr>
                                        <th style="width: 100px !important;">Sr. No.</th>
                                        <th style="width: 250px !important;">Employee Name</th>
                                        <th style="width: 200px !important;">Employee Code</th>
                                        <th style="width: 250px !important;">Employee Status</th>
                                        <th colspan="4">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Employee Name</th>
                                        <th>Employee Code</th>
                                        <th>Employee Status</th>
                                        <th colspan="4">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>

                            <!-- Existing Present Overtime Modal -->
                            <div class="modal fade" id="overtimeModal" tabindex="-1" aria-labelledby="overtimeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="overtimeModalLabel">Present Over Time (OT)</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-6 col-md-12">
                                                <label for="present_over_time">Over Time (OT)</label>
                                                <input type="number" class="form-control" id="present_over_time" name="present_over_time" placeholder="Over Time (OT)">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="saveOvertime">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Holiday Overtime Modal -->
                            <div class="modal fade" id="halfDayOverTimeModal" tabindex="-1" aria-labelledby="halfDayOverTimeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="halfDayOverTimeModalLabel">Half Day Over Time (OT)</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-6 col-md-12">
                                                <label for="half_day_over_time">Over Time (OT)</label>
                                                <input type="number" class="form-control" id="half_day_over_time" name="half_day_over_time" placeholder="Over Time (OT)">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="savehalfDayOvertime">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Existing Holiday Overtime Modal -->
                            <div class="modal fade" id="holidayOverTimeModal" tabindex="-1" aria-labelledby="holidayOverTimeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="holidayOverTimeModalLabel">Holiday Over Time (OT)</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-6 col-md-12">
                                                <label for="holiday_over_time">Over Time (OT)</label>
                                                <input type="number" class="form-control" id="holiday_over_time" name="holiday_over_time" placeholder="Over Time (OT)">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="saveHolidayOvertime">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer-script')

<script>

$(document).ready(function() {
    let Id; // Declare Id outside of event handlers

    // Event listener for 'Present' status
    $('#myTable').on('click', 'input[type="radio"][value="1"]', function() {
        Id = $(this).data('attendance-id');
        var overTime = $(this).data('over-time');
        $('#present_over_time').val(overTime);
        $('#overtimeModal').modal('show');
    });

    // Event listener for saving Present Overtime
    $('#saveOvertime').on('click', function() {
        const overtimeValue = $('#present_over_time').val();
        console.log('Present Overtime:', overtimeValue);
        $('<input>').attr({
            type: 'hidden',
            name: 'present_over_time[' + Id + ']',
            value: overtimeValue
        }).appendTo('#attendanceForm');
        $('#overtimeModal').modal('hide');
    });

    // Event listener for 'Half Day' status
    $('#myTable').on('click', 'input[type="radio"][value="2"]', function() {
        Id = $(this).data('attendance-id');
        var overTime = $(this).data('over-time');
        $('#half_day_over_time').val(overTime);
        $('#halfDayOverTimeModal').modal('show');
    });

    // Event listener for saving Half Day Overtime
    $('#savehalfDayOvertime').on('click', function() {
        const overtimeValue = $('#half_day_over_time').val();
        console.log('Half Day Overtime:', overtimeValue);
        $('<input>').attr({
            type: 'hidden',
            name: 'half_day_over_time[' + Id + ']',
            value: overtimeValue
        }).appendTo('#attendanceForm');
        $('#halfDayOverTimeModal').modal('hide');
    });

    // Event listener for 'Holiday' status
    $('#myTable').on('click', 'input[type="radio"][value="3"]', function() {
        Id = $(this).data('attendance-id');
        var overTime = $(this).data('over-time');
        $('#holiday_over_time').val(overTime);
        $('#holidayOverTimeModal').modal('show');
    });

    // Event listener for saving Holiday Overtime
    $('#saveHolidayOvertime').on('click', function() {
        const overtimeValue = $('#holiday_over_time').val();
        console.log('Holiday Overtime:', overtimeValue);
        $('<input>').attr({
            type: 'hidden',
            name: 'holiday_over_time[' + Id + ']',
            value: overtimeValue
        }).appendTo('#attendanceForm');
        $('#holidayOverTimeModal').modal('hide');
    });

    // Handle form submission
    $('#attendanceForm').on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                toastr.success('Attendance Update successfully!');
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    // Event listener for fetching attendance
    $('#fetchAttendanceBtn').on('click', function() {
        var attendance_date = $('#attendance_date').val();
        var company_id = $('#company_id').val();

        if (attendance_date && company_id) {
            $.ajax({
                url: '{{ route('fetch.attendance.by.date') }}',
                method: 'GET',
                data: {
                    attendance_date: attendance_date,
                    company_id: company_id
                },
                success: function(data) {

                    data.forEach((item, index) => {
                        let statusBadge = '';
                        let overtimeDisplay = item.over_time === 0 ? 'N/A' : item.over_time;

                        switch(item.status) {
                            case '1':
                                statusBadge = '<span class="badge bg-success">Present</span>';
                                break;
                            case '0':
                                statusBadge = '<span class="badge bg-danger">Absent</span>';
                                overtimeDisplay = ''; // No overtime display for absent
                                break;
                            case '2':
                                statusBadge = '<span class="badge bg-warning">Half Day</span>';
                                break;
                            case '3':
                                statusBadge = '<span class="badge bg-primary">Holiday</span>';
                                break;
                        }

                        $('#myTable tbody').append(`
                            <tr data-attendance-id="${item.id}">
                                <td>${index + 1} <input type="hidden" class="form-control" name="id[${item.id}]" value="${item.id}"> </td>
                                <td>${item.first_name} ${item.father_name} ${item.last_name}</td>
                                <td>${item.emp_code}</td>
                                <td>${statusBadge} ${item.status === '1' || item.status === '2' || item.status === '3' ? 'OT: ' + overtimeDisplay : ''}</td>
                                <td colspan="4">
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                        <li>
                                            <input class="form-check-input present-radio" type="radio"
                                                name="status[${item.id}]" value="1"
                                                data-attendance-id="${item.id}"
                                                data-employee-id="${item.employee_id}"
                                                data-over-time="${item.over_time}"
                                                ${item.status === '1' ? 'checked' : ''}>
                                            <label class="form-check-label">Present</label>
                                        </li>
                                        <li>
                                            <input class="form-check-input" type="radio"
                                                name="status[${item.id}]" data-attendance-id="${item.id}" value="0" ${item.status === '0' ? 'checked' : ''}>
                                            <label class="form-check-label">Absent</label>
                                        </li>
                                        <li>
                                            <input class="form-check-input" type="radio"
                                                name="status[${item.id}]" data-attendance-id="${item.id}" data-employee-id="${item.employee_id}"
                                                data-over-time="${item.over_time}" value="2" ${item.status === '2' ? 'checked' : ''}>
                                            <label class="form-check-label">Half Day</label>
                                        </li>
                                        <li>
                                            <input class="form-check-input" type="radio"
                                                name="status[${item.id}]" value="3"
                                                data-attendance-id="${item.id}"
                                                data-employee-id="${item.employee_id}"
                                                data-over-time="${item.over_time}"
                                                ${item.status === '3' ? 'checked' : ''}>
                                            <label class="form-check-label">Holiday</label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        `);

                    });

                    // Reinitialize DataTable

                    // Attach event listeners after appending rows
                    // attachEventListeners();
                }
            });
        } else {
            alert('Please select a company and date.');
        }
    });
});

$(document).ready(function() {
    $('#fetchAttendanceBtn').on('click', function() {
        // Get values from the form inputs
        var attendanceDate = $('#attendance_date').val();
        var companyId = $('#company_id').val();

        // Set values to the hidden inputs
        $('#hidden_attendance_date').val(attendanceDate);
        $('#hidden_company_id').val(companyId);
        console.log(attendanceDate);
        console.log(companyId);

        // Optional: you can make an AJAX call here to fetch and display the data
        $.ajax({
            url: '{{ route('fetch.attendance.by.date') }}',
            method: 'GET',
            data: {
                attendance_date: attendanceDate,
                company_id: companyId
            },
            success: function(response) {
                // Handle the response to display the fetched data
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});

</script>

@endsection
