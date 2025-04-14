@extends('admin.layouts.layout')
@section('content')

<style>
    .document{
    display: flex;
    flex-direction: column;
    align-items: center;
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
                            Edit Employee Detail
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
                <!-- Account details card -->
                <div class="card mb-4">
                    <div class="card-header">Employee Details</div>
                    <div class="card-body">
                        <form action="{{ route('employee_details.update', $employee->id ) }}" method="POST" enctype="multipart/form-data" id="empDetailUpdate">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$employee->id}}">
                            <input type="hidden" name="emp_code" value="{{$employee->emp_code}}">
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-4">
                                    <label for="productname">First Name <span class="text-danger">*</span></label>
                                    <input id="productname" name="first_name" type="text" class="form-control first_name @error('first_name') is-invalid @enderror" value="{{$employee->first_name}}" placeholder="First Name">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Surname Name <span class="text-danger">*</span></label>
                                    <input id="productname" name="last_name" type="text" class="form-control last_name @error('last_name') is-invalid @enderror" value="{{ $employee->last_name }}" placeholder="Surname Name">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="manufacturername">Father's Name <span class="text-danger">*</span></label>
                                    <input id="manufacturername" name="father_name" type="text" class="form-control father_name @error('father_name') is-invalid @enderror" value="{{ $employee->father_name }}" placeholder="Father's Name">
                                    @error('father_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Date Of Birth <span class="text-danger">*</span></label>
                                    <input id="productname" name="date_of_birth" type="text" class="form-control date_of_birth @error('date_of_birth') is-invalid @enderror" value="{{ $employee->date_of_birth }}" placeholder="Date Of Birth">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Phone No. <span class="text-danger">*</span></label>
                                    <input id="productname" name="phone_no" type="tel" class="form-control phone_no @error('phone_no') is-invalid @enderror" value="{{ $employee->phone_no }}" placeholder="Phone No.">
                                    @error('phone_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Employee Post <span class="text-danger">*</span></label>
                                    <select class="form-control emp_post @error('emp_post') is-invalid @enderror" name="emp_post_id" id="post">
                                        @if ($employee->emp_post_id === null || !$employee->getEmployeePost)
                                            <option value="">Select Employee Post</option>
                                        @else
                                            <option value="{{ $employee->getEmployeePost->id }}">{{ $employee->getEmployeePost->emp_post }}</option>
                                        @endif

                                        @foreach ($employeePost as $item)
                                            <option value="{{ $item->id }}">{{ $item->emp_post }}</option>
                                        @endforeach
                                    </select>

                                    @error('emp_post')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <lable>Date Of Joining <span class="text-danger">*</span></label>
                                    <input id="manufacturername" name="date_of_joining" type="text" class="form-control date_of_joining @error('date_of_joining') is-invalid @enderror" value="{{ $employee->date_of_joining }}" placeholder="Date Of Joining">
                                    @error('date_of_joining')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">UAN No.</label>
                                    <input id="productname" name="uan_no" type="text" class="form-control" value="{{ $employee->uan_no }}" placeholder="UAN No.">
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">City</label>
                                    <input id="productname" name="city" type="text" class="form-control" value="{{ $employee->city }}" placeholder="City">
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">State <span class="text-danger">*</span></label>
                                    <input id="productname" name="state" type="text" class="form-control state @error('state') is-invalid @enderror" value="{{ $employee->state }}" placeholder="State">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Postal Code <span class="text-danger">*</span></label>
                                    <input id="productname" name="postal_code" type="number" class="form-control postal_code @error('postal_code') is-invalid @enderror" value="{{ $employee->postal_code }}" placeholder="Postal Code">
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Employee Type <span class="text-danger">*</span></label>
                                    <select class="form-control emp_type @error('emp_type') is-invalid @enderror" name="emp_type" id="emp_type">
                                        <option value="{{$employee->emp_type}}">{{$employee->emp_type}}</option>
                                        <option value="Office Employee">Office Employee</option>
                                        <option value="Site Employee">Site Employee</option>
                                    </select>
                                    @error('emp_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4 col-md-4">
                                    <label for="productname">Income Type <span class="text-danger">*</span></label>
                                    <div class="row income_type">
                                        <div class="col-12">
                                            <select name="income_type" id="incomeType" class="form-control">
                                                <option value="1" @if ($employee->income_type === '1') selected @endif>Fix</option>
                                                <option value="0" @if ($employee->income_type === '0') selected @endif>Per Day</option>
                                                <option value="2" @if ($employee->income_type === '2') selected @endif>Fix + OT</option>
                                            </select>
                                        </div>

                                    </div>
                                    @error('income_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-4 col-md-4" id="daysInput" style="display: none;">
                                    <label for="productname">Days <span class="text-danger">*</span></label>
                                    <input id="productname" name="days" type="number" class="form-control days @error('days') is-invalid @enderror"
                                           value="{{ $employee->days }}" placeholder="Days">
                                </div>

                                <div class="col-4 col-md-4">
                                    <label for="productname">Income <span class="text-danger">*</span></label>
                                    <input id="productname" name="income" type="number" class="form-control income @error('income') is-invalid @enderror" value="{{ $employee->income }}" placeholder="Income">
                                    @error('income')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4 col-md-4">
                                    <label for="productname">Employee Status <span class="text-danger">*</span></label>
                                    <div class="row status">
                                        <div class="col-6">
                                            <input type="radio" name="status" value="1" id="statusActive" @if ($employee->status === '1') checked @endif>
                                            <label for="statusActive" style="padding-right: 10px;"><b> Active</b></label>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="status" value="0" id="statusInactive" @if ($employee->status === '0') checked @endif>
                                            <label for="statusInactive" style="padding-right: 10px;"><b> Inactive</b></label>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="status" value="2" id="statusTerminated" @if ($employee->status === '2') checked @endif data-bs-toggle="modal" data-bs-target="#terminationModalCenter" data-employee-id="{{ $employee->id }}">
                                            <label for="statusTerminated" style="padding-right: 10px;"><b> Terminated</b></label>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="status" value="3" id="statusResigned" @if ($employee->status === '3') checked @endif data-bs-toggle="modal" data-bs-target="#terminationModalCenter" data-employee-id="{{ $employee->id }}">
                                            <label for="statusResigned" style="padding-right: 10px;"><b> Resigned</b></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5 col-md-5">
                                    <label for="manufacturerbrand">Address</label>
                                    <textarea class="form-control" name="address" id="" cols="30" rows="5">{{ $employee->address }}</textarea>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card-header" style="background-color:#ffff;padding:20px 18px 20px 10px">Employee Bank Details</div>
                                        <div data-repeater-list="group-a" id="dynamicAddRemove">
                                            <div data-repeater-item class="row mb-2" style="padding: 6px">
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Aadhar No. <span class="text-danger">*</span></label>
                                                    <input id="productname" name="adhar_no" type="text" class="form-control adhar_no @error('adhar_no') is-invalid @enderror" value="{{ $employee->adhar_no }}" placeholder="Aadhar No.">
                                                    @error('adhar_no')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">PAN No.</label>
                                                    <input id="productname" name="pan_no" type="text" class="form-control" value="{{ $employee->pan_no }}" placeholder="PAN No.">
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Bank Name <span class="text-danger">*</span></label>
                                                    <input id="productname" name="bank_name" type="text" class="form-control bank_name @error('bank_name') is-invalid @enderror" value="{{ $employee->bank_name }}" placeholder="Bank Name">
                                                    @error('bank_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Branch <span class="text-danger">*</span></label>
                                                    <input id="productname" name="branch" type="text" class="form-control branch @error('branch') is-invalid @enderror" value="{{ $employee->branch }}" placeholder="Branch">
                                                    @error('branch')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">IFSC Code <span class="text-danger">*</span></label>
                                                    <input id="productname" name="ifsc_code" type="text" class="form-control ifsc_code @error('ifsc_code') is-invalid @enderror" value="{{ $employee->ifsc_code }}" placeholder="IFSC Code">
                                                    @error('ifsc_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Account Number <span class="text-danger">*</span></label>
                                                    <input id="productname" name="account_no" type="text" class="form-control account_no @error('account_no') is-invalid @enderror" value="{{ $employee->account_no }}" placeholder="Account Number">
                                                    @error('account_no')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Employee Photo <span class="text-danger">*</span></label>
                                                    <input id="productname" name="emp_photo" type="file" class="form-control emp_photo @error('emp_photo') is-invalid @enderror" value="{{ $employee->companyname }}" placeholder="Account Number">
                                                    @error('emp_photo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Aadhar Card <span class="text-danger">*</span></label>
                                                    <input id="productname" name="aadhar_card" type="file" class="form-control aadhar_card @error('aadhar_card') is-invalid @enderror" value="{{ $employee->aadhar_card }}" placeholder="Account Number">
                                                    @error('aadhar_card')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">PAN Card</label>
                                                    <input id="productname" name="pan_card" type="file" class="form-control" value="{{ $employee->pan_card }}" placeholder="Account Number">
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Passbook <span class="text-danger">*</span></label>
                                                    <input id="productname" name="passbook" type="file" class="form-control passbook @error('passbook') is-invalid @enderror" value="{{ $employee->passbook }}" placeholder="Account Number">
                                                    @error('passbook')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Police Verification</label>
                                                    <input id="productname" name="police_verification" type="file" class="form-control " value="{{ $employee->police_verification }}" placeholder="Account Number">
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Update Employee</button>
                        </form>

                        <!-- Termination Modal -->
                                                <div class="modal fade" id="terminationModalCenter" tabindex="-1" role="dialog" aria-labelledby="terminationModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalCenterTitle">Add Leave Date</h5>
                                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="terminationForm" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                                                                    <!-- Form fields -->
                                                                    <div class="row gx-3 mb-3">
                                                                        <div class="col-6 col-md-6">
                                                                            <label class="small mb-1" for="leave_date">Leave Date</label>
                                                                            <input class="form-control" id="leave_date" type="date" name="leave_date" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-primary" type="submit">Add Termination Date</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                        <div class="container mt-5">
                            <!-- Employee Document card-->
                            <div class="card mb-4">
                                <div class="card-header">Employee Document</div>
                                <div class="card-body p-0">
                                    <!-- Employee Document table-->
                                    <div class="table-responsive table-billing-history">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-gray-200" scope="col">Document Name</th>
                                                    <th class="border-gray-200" scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Employee Photo</td>
                                                    <td>
                                                        @if ($employee->employeeDocument && $employee->employeeDocument->emp_photo)
                                                            <a href="{{ asset('documents/emp_photos/'.$employee->employeeDocument->emp_photo) }}" target="_blank" rel="noopener noreferrer">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        @else
                                                            <p>No photo available</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Aadhar Card</td>
                                                    <td>
                                                        @if ($employee->employeeDocument && $employee->employeeDocument->aadhar_card)
                                                            <a href="{{asset('documents/aadhar_cards/'.$employee->employeeDocument->aadhar_card)}}" target="_blank" rel="noopener noreferrer">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        @else
                                                            <p>No photo available</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>PAN Card</td>
                                                    <td>
                                                        @if ($employee->employeeDocument && $employee->employeeDocument->pan_card)
                                                            <a href="{{asset('documents/pan_cards/'.$employee->employeeDocument->pan_card)}}" target="_blank" rel="noopener noreferrer">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        @else
                                                            <p>No photo available</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>PassBook</td>
                                                    <td>
                                                        @if ($employee->employeeDocument && $employee->employeeDocument->passbook)
                                                            <a href="{{asset('documents/passbooks/'.$employee->employeeDocument->passbook)}}" target="_blank" rel="noopener noreferrer">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        @else
                                                            <p>No photo available</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Police Verification</td>
                                                    <td>
                                                        @if ($employee->employeeDocument && $employee->employeeDocument->police_verification)
                                                            <a href="{{asset('documents/police_verifications/'.$employee->employeeDocument->police_verification)}}" target="_blank" rel="noopener noreferrer">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        @else
                                                            <p>No   photo available</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        $('#empDetailUpdate').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.invalid-feedback').remove();

            if ($('.first_name').val() === '') {
                isValid = false;
                $('.first_name').addClass('is-invalid').after('<div class="invalid-feedback">Please select a First Name.</div>');
            } else {
                $('.first_name').removeClass('is-invalid');
            }

            if ($('.last_name').val() === '') {
                isValid = false;
                $('.last_name').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Surname.</div>');
            } else {
                $('.last_name').removeClass('is-invalid');
            }

            if ($('.father_name').val() === '') {
                isValid = false;
                $('.father_name').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Father Name.</div>');
            } else {
                $('.father_name').removeClass('is-invalid');
            }

            if ($('.date_of_birth').val() === '') {
                isValid = false;
                $('.date_of_birth').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Date Of Birth.</div>');
            } else {
                $('.date_of_birth').removeClass('is-invalid');
            }

            if ($('.phone_no').val() === '') {
                isValid = false;
                $('.phone_no').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Phone No.</div>');
            } else {
                $('.phone_no').removeClass('is-invalid');
            }

            if ($('.date_of_joining').val() === '') {
                isValid = false;
                $('.date_of_joining').addClass('is-invalid').after('<div class="invalid-feedback">Please select a date Of Joining.</div>');
            } else {
                $('.date_of_joining').removeClass('is-invalid');
            }

            if ($('.state').val() === '') {
                isValid = false;
                $('.state').addClass('is-invalid').after('<div class="invalid-feedback">Please select a State.</div>');
            } else {
                $('.state').removeClass('is-invalid');
            }

            if ($('.postal_code').val() === '') {
                isValid = false;
                $('.postal_code').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Postal Code.</div>');
            } else {
                $('.postal_code').removeClass('is-invalid');
            }

            if ($('.emp_type').val() === '') {
                isValid = false;
                $('.emp_type').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Employee Type.</div>');
            } else {
                $('.emp_type').removeClass('is-invalid');
            }

            if ($('#incomeType').val() === '') {
                isValid = false;
                $('.income_type').addClass('is-invalid').after('<div class="invalid-feedback">Please select an Income Type.</div>');
            } else {
                $('.income_type').removeClass('is-invalid');
                $('.invalid-feedback').remove();  // Remove any existing error messages
            }


            if ($('.income').val() === '') {
                isValid = false;
                $('.income').addClass('is-invalid').after('<div class="invalid-feedback">Please enter an Income.</div>');
            } else {
                $('.income').removeClass('is-invalid');
            }

            if (!$('input[name="status"]:checked').val()) {
                isValid = false;
                $('.status').addClass('is-invalid').after('<div class="invalid-feedback">Please select an Employee Status.</div>');
            } else {
                $('.status').removeClass('is-invalid');
            }

            if ($('.adhar_no').val() === '') {
                isValid = false;
                $('.adhar_no').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Aadhar No.</div>');
            } else {
                $('.adhar_no').removeClass('is-invalid');
            }

            if ($('.pan_no').val() === '') {
                isValid = false;
                $('.pan_no').addClass('is-invalid').after('<div class="invalid-feedback">Please select a PAN No.</div>');
            } else {
                $('.pan_no').removeClass('is-invalid');
            }

            if ($('.bank_name').val() === '') {
                isValid = false;
                $('.bank_name').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Bank Name.</div>');
            } else {
                $('.bank_name').removeClass('is-invalid');
            }

            if ($('.branch').val() === '') {
                isValid = false;
                $('.branch').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Branch.</div>');
            } else {
                $('.branch').removeClass('is-invalid');
            }

            if ($('.ifsc_code').val() === '') {
                isValid = false;
                $('.ifsc_code').addClass('is-invalid').after('<div class="invalid-feedback">Please select a IFSC Code.</div>');
            } else {
                $('.ifsc_code').removeClass('is-invalid');
            }

            if ($('.account_no').val() === '') {
                isValid = false;
                $('.account_no').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Account No.</div>');
            } else {
                $('.account_no').removeClass('is-invalid');
            }

            if ($('.emp_post').val() === '') {
                isValid = false;
                $('.emp_post').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Employee Post.</div>');
            } else {
                $('.emp_post').removeClass('is-invalid');
            }

            // Prevent form submission if not valid
            if (!isValid) {
                e.preventDefault();
            }
        });
    });

    $(document).ready(function() {
        // Check if the Fix Income radio button is checked on page load
        $('#incomeType').change(function() {
            if ($('#incomeType').val() === '1') { // Fix Income is selected
                $('#daysInput').show();
            } else {
                $('#daysInput').hide();
            }
        });

        // Trigger the change event on page load to ensure it works when the page is loaded with a pre-selected value
        $(document).ready(function() {
            $('#incomeType').trigger('change');
        });


        // Show/Hide the Days input field based on radio button change
        $('input[name="income_type"]').change(function() {
            if ($('#fixIncome').is(':checked')) {
                $('#daysInput').show();
            } else {
                $('#daysInput').hide();
            }
        });
    });

</script>

@endsection
