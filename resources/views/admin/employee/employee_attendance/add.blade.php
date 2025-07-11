@extends('admin.layouts.layout')
@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endpush
@section('content')
<style>
    .pagination {
        display: flex;
        justify-content: center;
    }
    .pagination li {
        margin: 0 5px;
    }

    .highlighted-date {
        background-color: #90ee90; /* Light green */
        color: black;
    }

    .missing-date {
        background-color: #ffcccc; /* Light red for dates that are not stored */
        color: black;
    }

    .ui-state-default, .ui-widget-content .ui-state-default {
        border: none;
        background: none;
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
                        <form id="attendanceForm" action="{{ route('employee_attendance.store') }}" method="POST">
                            @csrf
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="company_id">Company name <span class="text-danger">*</span></label>
                                    <select class="form-control company_id  @error('company_id') is-invalid @enderror" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $item)
                                            <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="attendance_date">Attendance Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control attendance_date @error('attendance_date') is-invalid @enderror" name="attendance_date" id="attendance_date" >
                                    <input type="hidden" id="stored_date" name="stored_date" />
                                 </div>
                                @error('attendance_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <table id="attendanceTable" class="mt-5 table ">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Employee Name</th>
                                        <th>Employee Code</th>
                                        <th>Action</th>
                                        <th>Over Time (OT)</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Employee Name</th>
                                        <th>Employee Code</th>
                                        <th>Action</th>
                                        <th>Over Time (OT)</th>
                                    </tr>
                                </tfoot>
                                <tbody id="tableBody">
                                    @php $i = 1; @endphp
                                    @foreach ($employees as $employee)
                                        <tr data-company-id="{{ $employee->company_id }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $employee->first_name }} {{ $employee->father_name }} {{ $employee->last_name }} </td>
                                            <td>{{ $employee->emp_code }}</td>
                                            <td>
                                                <ul class="list-unstyled hstack gap-1 mb-0">
                                                    <li>
                                                        <input class="form-check-input present-radio" type="radio" name="status[{{ $employee->id }}]" value="1" data-employee-id="{{ $employee->id }}">
                                                        <label class="form-check-label">Present</label>
                                                    </li>
                                                    <li>
                                                        <input class="form-check-input" type="radio" name="status[{{ $employee->id }}]" value="0">
                                                        <label class="form-check-label">Absent</label>
                                                    </li>
                                                    <li>
                                                        <input class="form-check-input" type="radio" name="status[{{ $employee->id }}]" value="2" data-employee-id="{{ $employee->id }}">
                                                        <label class="form-check-label">Half Day</label>
                                                    </li>
                                                    <li>
                                                        <input class="form-check-input" type="radio" name="status[{{ $employee->id }}]" value="3" data-employee-id="{{ $employee->id }}">
                                                        <label class="form-check-label">Holiday</label>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <input class="form-control over-time-input" type="number" name="present_over_time[{{ $employee->id }}]" value="0" data-employee-id="{{ $employee->id }}">
                                                <input class="form-control over-time-input d-none" type="number" name="half_day_over_time[{{ $employee->id }}]" value="0" data-employee-id="{{ $employee->id }}">
                                                <input class="form-control over-time-input d-none" type="number" name="holiday_over_time[{{ $employee->id }}]" value="0" data-employee-id="{{ $employee->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary mt-3">Submit Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer-script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

$(document).on('change', 'input[type=radio][name^="status"]', function () {
    var employeeId = $(this).data('employee-id');
    var status = $(this).val();

    // Hide all OT inputs first
    $('input[name^="present_over_time[' + employeeId + ']"]').addClass('d-none');
    $('input[name^="half_day_over_time[' + employeeId + ']"]').addClass('d-none');
    $('input[name^="holiday_over_time[' + employeeId + ']"]').addClass('d-none');

    if (status == 1) {
        $('input[name^="present_over_time[' + employeeId + ']"]').removeClass('d-none');
    } else if (status == 2) {
        $('input[name^="half_day_over_time[' + employeeId + ']"]').removeClass('d-none');
    } else if (status == 3) {
        $('input[name^="holiday_over_time[' + employeeId + ']"]').removeClass('d-none');
    }
});

$(document).ready(function() {
    let currentEmployeeId;

    // Show Present Overtime Modal
    $('#attendanceTable').on('click', 'input[type="radio"][value="1"]', function() {
        currentEmployeeId = $(this).data('employee-id');
        $('#overtimeModal').modal('show');
    });

    // Save Present Overtime
    $('#saveOvertime').on('click', function() {
        const overtimeValue = $('#present_over_time').val();
        console.log('Present Overtime:', overtimeValue);  // Debug log
        $('<input>').attr({
            type: 'hidden',
            name: 'present_over_time[' + currentEmployeeId + ']',
            value: overtimeValue
        }).appendTo('#attendanceForm');
        $('#overtimeModal').modal('hide');
    });

    // Show Half Day Overtime Modal
    $('#attendanceTable').on('click', 'input[type="radio"][value="2"]', function() {
        currentEmployeeId = $(this).data('employee-id');
        $('#halfDayOverTimeModal').modal('show');
    });

    // Save Half Day Overtime
    $('#savehalfDayOvertime').on('click', function() {
        const overtimeValue = $('#half_day_over_time').val();
        console.log('Half Day Overtime:', overtimeValue);  // Debug log
        $('<input>').attr({
            type: 'hidden',
            name: 'half_day_over_time[' + currentEmployeeId + ']',
            value: overtimeValue
        }).appendTo('#attendanceForm');
        $('#halfDayOverTimeModal').modal('hide');
    });

    // Show Holiday Overtime Modal
    $('#attendanceTable').on('click', 'input[type="radio"][value="3"]', function() {
        currentEmployeeId = $(this).data('employee-id');
        $('#holidayOverTimeModal').modal('show');
    });

    // Save Holiday Overtime
    $('#saveHolidayOvertime').on('click', function() {
        const overtimeValue = $('#holiday_over_time').val();
        console.log('Holiday Overtime:', overtimeValue);  // Debug log
        $('<input>').attr({
            type: 'hidden',
            name: 'holiday_over_time[' + currentEmployeeId + ']',
            value: overtimeValue
        }).appendTo('#attendanceForm');
        console.log('Holiday Overtime Hidden Input:', {
            name: 'holiday_over_time[' + currentEmployeeId + ']',
            value: overtimeValue
        });  // Debug log
        $('#holidayOverTimeModal').modal('hide');
    });
});

// $(document).ready(function() {
//     var table = $('#attendanceTable').DataTable();

//     if ( ! $.fn.DataTable.isDataTable('#attendanceTable') ) {
//         table = $('#attendanceTable').DataTable({
//             // DataTable options here
//             "paging": false,
//             "autoWidth": false,
//         });
//     }

//     $.fn.dataTable.ext.search.push(
//         function(settings, data, dataIndex) {
//             var companyId = $('#company_id').val().trim();
//             var rowCompanyId = table.row(dataIndex).node().getAttribute('data-company-id');

//             if (companyId === '' || rowCompanyId === companyId) {
//                 return true;
//             }
//             return false;
//         }
//     );

//     $('#company_id').on('change', function() {
//         table.draw();
//     });
// });

$(document).ready(function () {
    $('#company_id').on('change', function () {
        var selectedCompanyId = $(this).val().trim();

        $('#attendanceTable tbody tr').each(function () {
            var rowCompanyId = $(this).data('company-id');

            if (selectedCompanyId === '' || rowCompanyId == selectedCompanyId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});


$(function() {
    let highlightedDates = [];

    $("#attendance_date").datepicker({
        dateFormat: 'dd-mm-yy', // Display date in dd-mm-yyyy format
        beforeShowDay: function(date) {
            let storeDateFormat = $.datepicker.formatDate('yy-mm-dd', date); // Store in yyyy-mm-dd format
            let today = new Date();
            today.setHours(0, 0, 0, 0); // Normalize today’s date for comparison

            if (date > today) {
                return [false, 'disabled-date']; // Disable future dates
            }

            // Logic to check and highlight dates
            if (highlightedDates.includes(storeDateFormat)) {
                return [true, 'highlighted-date']; // Add highlighted class if the date is in the array
            } else {
                return [true, 'missing-date']; // Add missing-date class for dates not in the array
            }
        },
        onSelect: function(dateText, inst) {
            let selectedDate = $(this).datepicker('getDate');
            let storeDate = $.datepicker.formatDate('yy-mm-dd', selectedDate);

            $("#stored_date").val(storeDate); // Store the selected date
            $("#attendance_date").val(storeDate).trigger('change');

        }
    });

    $('#company_id').on('change', function() {
        let companyId = $(this).val();
        $.ajax({
            url: '{{ route('attendance.check') }}',
            method: 'GET',
            data: { company_id: companyId },
            success: function(response) {
                highlightedDates = response.dates;
                $("#attendance_date").datepicker('refresh');
            }
        });
    });
});

$(document).ready(function () {
    $('#attendanceForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission initially

        let isValid = true;

        // Clear previous error messages
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');

        // Validate Company Name
        if ($('.company_id').val() === '') {
            isValid = false;
            $('.company_id').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Company Name.</div>');
        }

        // Validate Attendance Date
        if ($('.attendance_date').val() === '') {
            isValid = false;
            $('.attendance_date').addClass('is-invalid').after('<div class="invalid-feedback">Please select an Attendance Date.</div>');
        }

        // Stop the form submission if validation fails
        if (!isValid) {
            return;
        }

        // Proceed with AJAX if validation passes
        const formData = $(this).serialize();
        console.log('Form Data:', formData);  // Debugging log

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                toastr.success('Attendance saved successfully!');
                $('#attendanceForm')[0].reset(); // Reset form after successful submission
            }
        });
    });
});

$('#company_id, #attendance_date').on('change', function () {
    const companyId = $('#company_id').val();
    const attendanceDate = $('#attendance_date').val();

    console.log('Company ID:', companyId);
    console.log('Attendance Date:', attendanceDate);

    if (companyId && attendanceDate) {stored_date
        $.ajax({
            url: '{{ route("employee_attendance.fetch") }}',
            method: 'GET',
            data: {
                company_id: companyId,
                attendance_date: attendanceDate
            },
            success: function(response) {
                updateAttendanceTable(response.attendance);
            }
        });
    }
});

function updateAttendanceTable(data) {
    // Reset all rows
    $('input[type=radio]').prop('checked', false);
    $('.over-time-input').val(0).addClass('d-none');

    $.each(data, function(index, item) {
        // Select the correct radio button
        $('input[name="status[' + item.emp_id + ']"][value="' + item.status + '"]').prop('checked', true);

        // Hide all overtime inputs for this employee
        $('input[name^="present_over_time[' + item.emp_id + ']"]').addClass('d-none');
        $('input[name^="half_day_over_time[' + item.emp_id + ']"]').addClass('d-none');
        $('input[name^="holiday_over_time[' + item.emp_id + ']"]').addClass('d-none');

        // Show and set value for relevant overtime input
        if (item.status == 1) {
            $('input[name="present_over_time[' + item.emp_id + ']"]').removeClass('d-none').val(item.over_time);
        } else if (item.status == 2) {
            $('input[name="half_day_over_time[' + item.emp_id + ']"]').removeClass('d-none').val(item.over_time);
        } else if (item.status == 3) {
            $('input[name="holiday_over_time[' + item.emp_id + ']"]').removeClass('d-none').val(item.over_time);
        }
    });
}

</script>

@endsection
