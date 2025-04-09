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
                            Add Employee Detail
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
                        <form action="{{ route('employee_details.store') }}" method="POST" enctype="multipart/form-data" id="empDetail">
                            @csrf
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-4">
                                    <label for="productname">First Name <span class="text-danger">*</span></label>
                                    <input id="productname" name="first_name" type="text" class="form-control first_name @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="First Name">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Surname Name <span class="text-danger">*</span></label>
                                    <input id="productname" name="last_name" type="text" class="form-control last_name @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="Surname Name">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="manufacturername">Father's Name <span class="text-danger">*</span></label>
                                    <input id="manufacturername" name="father_name" type="text" class="form-control father_name @error('father_name') is-invalid @enderror" value="{{ old('father_name') }}" placeholder="Father's Name">
                                    @error('father_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Date Of Birth <span class="text-danger">*</span></label>
                                    <input id="productname" name="date_of_birth" type="date" class="form-control date_of_birth @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" placeholder="Date Of Birth">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Phone No. <span class="text-danger">*</span></label>
                                    <input id="productname" name="phone_no" type="tel" class="form-control phone_no @error('phone_no') is-invalid @enderror" value="{{ old('phone_no') }}" placeholder="Phone No.">
                                    @error('phone_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Employee Post <span class="text-danger">*</span></label>
                                    <select class="form-control emp_post @error('emp_post') is-invalid @enderror" name="emp_post_id" id="post">
                                        <option value="">Select Employee Post</option>
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
                                    <input id="manufacturername" name="date_of_joining" type="date" class="form-control date_of_joining @error('date_of_joining') is-invalid @enderror" value="{{ old('date_of_joining') }}" placeholder="Date Of Joining">
                                    @error('date_of_joining')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">UAN No.</label>
                                    <input id="productname" name="uan_no" type="text" class="form-control" value="{{ old('uan_no') }}" placeholder="UAN No.">
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">City</label>
                                    <input id="productname" name="city" type="text" class="form-control" value="{{ old('city') }}" placeholder="City">
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">State <span class="text-danger">*</span></label>
                                    <input id="productname" name="state" type="text" class="form-control state @error('state') is-invalid @enderror" value="{{ old('state') }}" placeholder="State">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Postal Code <span class="text-danger">*</span></label>
                                    <input id="productname" name="postal_code" type="number" class="form-control postal_code @error('postal_code') is-invalid @enderror" value="{{ old('postal_code') }}" placeholder="Postal Code">
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">Employee Type <span class="text-danger">*</span></label>
                                    <select class="form-control emp_type @error('emp_type') is-invalid @enderror" name="emp_type" id="emp_type">
                                        <option value="">Select Employee Type</option>
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
                                        <div class="col-6 ">
                                            <input type="radio" name="income_type" value="1" id="fixIncomeRadio">
                                            <label for="statusCheckbox" style="padding-right: 10px;"><b> Fix Income</b></label>
                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="income_type" value="0" id="statusCheckbox">
                                            <label for="statusCheckbox" style="padding-right: 10px;"><b> Per Day Income</b></label>
                                        </div>
                                    </div>
                                    @error('income_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3 col-md-3">
                                    <label for="productname">Income <span class="text-danger">*</span></label>
                                    <input id="productname" name="income" type="number" class="form-control income @error('income') is-invalid @enderror" value="{{ old('income') }}" placeholder="Income">
                                    @error('income')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-5 col-md-5">
                                    <label for="manufacturerbrand">Address</label>
                                    <textarea class="form-control" name="address" id="" cols="30" rows="5">{{ old('address') }}</textarea>
                                </div>
                                <div class="col-3 col-md-3" id="daysInput" style="margin-top: -40px; display: none;">
                                    <label for="productname">Days <span class="text-danger">*</span></label>
                                    <input id="productname" name="days" type="number" class="form-control "
                                           value="{{ old('days') }}" placeholder="Days">
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card-header" style="background-color:#ffff;padding:20px 18px 20px 10px">Employee Bank Details</div>
                                        <div data-repeater-list="group-a" id="dynamicAddRemove">
                                            <div data-repeater-item class="row mb-2" style="padding: 6px">
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Aadhar No. <span class="text-danger">*</span></label>
                                                    <input id="productname" name="adhar_no" type="text" class="form-control adhar_no @error('adhar_no') is-invalid @enderror" value="{{ old('adhar_no') }}" placeholder="Aadhar No.">
                                                    @error('adhar_no')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">PAN No.</label>
                                                    <input id="productname" name="pan_no" type="text" class="form-control" value="{{ old('pan_no') }}" placeholder="PAN No.">
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Bank Name <span class="text-danger">*</span></label>
                                                    <input id="productname" name="bank_name" type="text" class="form-control bank_name @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}" placeholder="Bank Name">
                                                    @error('bank_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Branch <span class="text-danger">*</span></label>
                                                    <input id="productname" name="branch" type="text" class="form-control branch @error('branch') is-invalid @enderror" value="{{ old('branch') }}" placeholder="Branch">
                                                    @error('branch')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">IFSC Code <span class="text-danger">*</span></label>
                                                    <input id="productname" name="ifsc_code" type="text" class="form-control ifsc_code @error('ifsc_code') is-invalid @enderror" value="{{ old('ifsc_code') }}" placeholder="IFSC Code">
                                                    @error('ifsc_code')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Account Number <span class="text-danger">*</span></label>
                                                    <input id="productname" name="account_no" type="text" class="form-control account_no @error('account_no') is-invalid @enderror" value="{{ old('account_no') }}" placeholder="Account Number">
                                                    @error('account_no')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Employee Photo <span class="text-danger">*</span></label>
                                                    <input id="productname" name="emp_photo" type="file" class="form-control emp_photo @error('emp_photo') is-invalid @enderror" value="{{ old('companyname') }}" placeholder="Account Number">
                                                    @error('emp_photo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Aadhar Card <span class="text-danger">*</span></label>
                                                    <input id="productname" name="aadhar_card" type="file" class="form-control aadhar_card @error('aadhar_card') is-invalid @enderror" value="{{ old('aadhar_card') }}" placeholder="Account Number">
                                                    @error('aadhar_card')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">PAN Card</label>
                                                    <input id="productname" name="pan_card" type="file" class="form-control" value="{{ old('pan_card') }}" placeholder="Account Number">
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Passbook <span class="text-danger">*</span></label>
                                                    <input id="productname" name="passbook" type="file" class="form-control passbook @error('passbook') is-invalid @enderror" value="{{ old('passbook') }}" placeholder="Account Number">
                                                    @error('passbook')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label for="productname">Police Verification</label>
                                                    <input id="productname" name="police_verification" type="file" class="form-control" value="{{ old('police_verification') }}" placeholder="Account Number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Add Employee</button>
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
    $(document).ready(function () {
        $('#empDetail').on('submit', function (e) {
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

            if (!$('input[name="income_type"]:checked').val()) {
                isValid = false;
                $('.income_type').addClass('is-invalid').after('<div class="invalid-feedback">Please select an Income Type.</div>');
            } else {
                $('.income_type').removeClass('is-invalid');
            }


            if ($('.income').val() === '') {
                isValid = false;
                $('.income').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Income.</div>');
            } else {
                $('.income').removeClass('is-invalid');
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

            if ($('.emp_photo').val() === '') {
                isValid = false;
                $('.emp_photo').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Employee Photo.</div>');
            } else {
                $('.emp_photo').removeClass('is-invalid');
            }

            if ($('.aadhar_card').val() === '') {
                isValid = false;
                $('.aadhar_card').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Aadhar Card.</div>');
            } else {
                $('.aadhar_card').removeClass('is-invalid');
            }

            if ($('.pan_card').val() === '') {
                isValid = false;
                $('.pan_card').addClass('is-invalid').after('<div class="invalid-feedback">Please select a PAN Card.</div>');
            } else {
                $('.pan_card').removeClass('is-invalid');
            }

            if ($('.passbook').val() === '') {
                isValid = false;
                $('.passbook').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Passbook.</div>');
            } else {
                $('.passbook').removeClass('is-invalid');
            }

            if ($('.police_verification').val() === '') {
                isValid = false;
                $('.police_verification').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Police  Verification.</div>');
            } else {
                $('.police_verification').removeClass('is-invalid');
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
        // When the radio button is clicked, show the input field for "Days"
        $('#fixIncomeRadio').on('click', function() {
            $('#daysInput').show();  // Show the "Days" input field
        });
    });

</script>

@endsection
