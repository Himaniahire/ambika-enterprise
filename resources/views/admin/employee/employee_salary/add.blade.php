@extends('admin.layouts.layout')
@section('content')
<style>
    .pagination {
        display: flex;
        justify-content: center;
    }
    .pagination li {
        margin: 0 5px;
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
                            Add Employee Salary
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
                <!-- Account Salarys card -->
                <div class="card mb-4">
                    <div class="card-header">Employee Salary</div>
                    <div class="card-body">
                        <form id="getEmployeeForm" method="POST">
                            @csrf
                            <div class="row gx-3 mb-3">
                                <div class="col-4 col-md-4">
                                    <label for="company_id">Company name <span class="text-danger">*</span></label>
                                    <select class="form-control company_id @error('company_id') is-invalid @enderror" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $item)
                                            <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4 col-md-4">
                                    <label for="salary_month">Salary Month <span class="text-danger">*</span></label>
                                    <input type="month" class="form-control salary_month @error('salary_month') is-invalid @enderror" name="salary_month" id="salary_month">
                                    @error('salary_month')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4 col-md-4">
                                    <button type="submit" class="btn btn-primary mt-4" id="getEmp">Get Employee</button>
                                </div>
                            </div>
                        </form>

                        <form id="employeeDetailsForm" method="post" action="{{route('employee_salary.store')}}">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div id="invoiceCount" class="text-danger"></div>
                                    <div data-repeater-list="group-a" id="dynamicAddRemove">
                                        <div data-repeater-item class="row mb-2" style="padding: 6px">
                                            <div class="col-6 col-md-6">
                                                <input type="hidden" name="hidden_com_id" id="hidden_com_id" value="">
                                                <input type="hidden" class="form-control" name="hidden_salary_month" id="hidden_salary_month" value="">
                                            </div>
                                            <table class="table" id="employeeTable">
                                                <thead></thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Generate Salary</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery CDN -->

<script>
$(document).ready(function () {
    $('#getEmployeeForm').on('submit', function (e) {
        let isValid = true;

        // Clear previous error messages
        $('.invalid-feedback').remove();

        if ($('.company_id').val() === '') {
            isValid = false;
            $('.company_id').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Company Name.</div>');
        } else {
            $('.company_id').removeClass('is-invalid');
        }

        if ($('.salary_month').val() === '') {
            isValid = false;
            $('.salary_month').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Salary.</div>');
        } else {
            $('.salary_month').removeClass('is-invalid');
        }
        // Prevent form submission if not valid
        if (!isValid) {
            e.preventDefault();
        }
    });
});

$(document).ready(function() {
    // Function to calculate the number of days in a month
    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    // Function to set emp_days based on the number of days in the month
    function setEmpDays(row, daysInMonth) {
        let empDays;

        if (daysInMonth === 31) {
            empDays = 27;
        } else if (daysInMonth === 30) {
            empDays = 26;
        } else if (daysInMonth === 29) {
            empDays = 25;
        } else if (daysInMonth === 28) {
            empDays = 24;
        }

        row.find('.emp_days').val(empDays);
    }

    // Function to calculate salary
    function calculateSalary(row) {
        const empIncome = parseFloat(row.find('.income').val()) || 0;
        const totalPresent = parseFloat(row.find('.total_present').val()) || 0;
        const totalOT = parseFloat(row.find('.total_ot').val()) || 0;
        const empDays = parseFloat(row.find('.emp_days').val()) || 0; // Default to 30 days if not provided
        const incomeType = parseInt(row.find('.income_type').val()) || 0; // Get income type
        const empCategory = parseInt(row.find('.emp_category').val()) || 0; // Get Emp Category
        const deductAdvance = parseFloat(row.find('.deduct_advance').val()) || 0; // Get deduct advance amount

        let salary;

        if (incomeType === 0) {
            // Income type 0 calculation
            const otIncome = (empIncome / 8) * totalOT * 2;
            salary = (empIncome * totalPresent) + otIncome;
        } else if (incomeType === 1) {
            // Income type 1 calculation
            salary = ((empIncome * totalPresent) / empDays) + (((empIncome / empDays) / 10) * totalOT);
        } else if (empCategory === 3) {
            // Employee Category 3 calculation
            const otIncome = (empIncome / 8) * totalOT;
            salary = (empIncome * totalPresent) + otIncome;
        }

        // Subtract deduct advance from calculated salary
        salary -= deductAdvance;

        // Format the salary to two decimal places
        salary = parseFloat(salary).toFixed(2);

        // Convert the salary to a number to remove trailing zeros
        let roundedSalary = parseFloat(salary);

        // Check the value of the decimal part after two digits
        const decimalPart = salary.split('.')[1];
        if (parseInt(decimalPart) >= 50) {
            // Round off to the nearest whole number if the decimal part is 50 or more
            roundedSalary = Math.ceil(roundedSalary);
        } else if (parseInt(decimalPart) <= 49) {
            // Round down to the nearest whole number if the decimal part is 49 or less
            roundedSalary = Math.floor(roundedSalary);
        }

        // Update the salary field
        row.find('.salary').val(roundedSalary);
    }

    // Trigger salary calculation when values change
    $(document).on('input', 'input', function() {
        const row = $(this).closest('tr');
        calculateSalary(row);
    });

    $('#getEmployeeForm').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "{{ route('getEmployeeData') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
    // Clear existing rows
    $('#employeeTable tbody').empty();

    // Set Table Header
    $('#employeeTable thead').html(`
        <tr>
            <th>Sr No.</th>
            <th>Emp Code <span class="text-danger">*</span></th>
            <th>Emp Name <span class="text-danger">*</span></th>
            <th>Emp Income <span class="text-danger">*</span></th>
            <th>Total Present <span class="text-danger">*</span></th>
            <th>Leave <span class="text-danger">*</span></th>
            <th>OT <span class="text-danger">*</span></th>
            <th>Advance/Remain <span class="text-danger">*</span></th>
            <th>Deduct Advance <span class="text-danger">*</span></th>
            <th>Salary <span class="text-danger">*</span></th>
            <th>Additional Amount <span class="text-danger">*</span></th>
            <th>Note</th>
        </tr>
    `);

    // Check if employees are found
    if (response.employees.length === 0) {
        $('#employeeTable tbody').html(`
            <tr>
                <td colspan="12" class="text-center text-danger">No Employees Found</td>
            </tr>
        `);
        return;
    }

    // Iterate over the employees and append rows
    $.each(response.employees, function(index, employee) {
        let attendance = response.attendanceData.find(att => att.emp_id == employee.id);
        let empCategory = employee.getEmployeePost?.getEmployeeCategory?.id || '';

        $('#employeeTable tbody').append(`
            <tr>
                <td class="mb-3 col-lg-1" style="width: 5%;">
                    <input type="text" style="text-align: center;" name="sr_no[]" class="form-control sr_no" value="${index + 1}" readonly />
                </td>
                <td class="mb-3 col-lg-3" style="width: 6%;">
                    <input type="text" name="emp_code[]" class="form-control emp_code" value="${employee.emp_code}" placeholder="Emp Code" readonly />
                </td>
                <td class="mb-3 col-lg-3" style="width: 12%;">
                    <input type="text" name="emp_name[]" class="form-control emp_name" value="${employee.first_name} ${employee.father_name} ${employee.last_name}" placeholder="Emp Name" readonly />
                    <input type="hidden" name="emp_id[]" class="form-control emp_id" value="${employee.id}" />
                    <input type="hidden" name="emp_days[]" class="form-control emp_days" value="${employee.days}" />
                    <input type="hidden" name="emp_category[]" class="form-control emp_category" value="${empCategory}" />
                </td>
                <td class="mb-3 col-lg-3" style="width: 6%;">
                    <input type="text" name="income[]" class="form-control income" value="${employee.income}" placeholder="Income" readonly />
                    <input type="hidden" name="income_type[]" class="form-control income_type" value="${employee.income_type}" />
                </td>
                <td class="mb-3 col-lg-3" style="width: 5%;">
                    <input type="text" name="total_present[]" class="form-control total_present" value="${attendance ? attendance.total_present : ''}" placeholder="Total P" readonly />
                </td>
                <td class="mb-3 col-lg-3" style="width: 5%;">
                    <input type="text" name="total_leave[]" class="form-control total_leave" value="${attendance ? attendance.total_leave : ''}" placeholder="Leave" />
                </td>
                <td class="mb-3 col-lg-3" style="width: 5%;">
                    <input type="text" name="total_ot[]" class="form-control total_ot" value="${attendance ? attendance.total_ot : ''}" placeholder="OT" readonly />
                </td>
                <td class="mb-3 col-lg-3" style="width: 5%;">
                    <input type="text" name="advance[]" class="form-control advance" value="${attendance ? attendance.advance_amount : ''}" placeholder="Advance" style="margin-bottom: 5px;" readonly />
                    <input type="text" name="remaining[]" class="form-control remaining" value="${employee.advance || ''}" placeholder="Remaining" readonly />
                </td>
                <td class="mb-3 col-lg-3" style="width: 5%;">
                    <input type="text" name="deduct_advance[]" class="form-control deduct_advance" value="" placeholder="Deduct Advance" />
                </td>
                <td class="mb-3 col-lg-3" style="width: 8%;">
                    <input type="text" name="salary[]" class="form-control salary" value="" placeholder="Salary" readonly />
                </td>
                <td class="mb-3 col-lg-3" style="width: 5%;">
                    <input type="text" name="additional_amount[]" class="form-control additional_amount" value="" placeholder="Additional Amount" />
                </td>
                <td class="mb-3 col-lg-1">
                    <textarea class="form-control note" name="note[]" placeholder="Note"></textarea>
                </td>
            </tr>
        `);

        // Call salary calculation after appending the row
        calculateSalary($('#employeeTable tbody tr:last'));
    });
},

            error: function(response) {
                console.log('Error:', response);
            }
        });
    });

});

$(document).ready(function() {
    $('#getEmployeeForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the values from the form
        var companyId = $('#company_id').val();
        var salaryMonth = $('#salary_month').val();

        // Set the values in the hidden inputs
        $('#hidden_com_id').val(companyId);
        $('#hidden_salary_month').val(salaryMonth);

        // Optionally, you can now submit the form or handle it as needed
        // For example, you might want to use AJAX to submit the form:
        // $.ajax({
        //     url: $(this).attr('action'),
        //     method: 'POST',
        //     data: $(this).serialize(),
        //     success: function(response) {
        //         // Handle the response
        //     }
        // });
    });
});

</script>

@endsection
