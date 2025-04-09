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
                            Add Register Company
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-primary" href="{{route('register_company.index')}}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Register Company List
                        </a>
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
                    <div class="card-header">Register Company Details</div>
                    <div class="card-body">
                        <form id="registerCompanyForm" action="{{ route('register_company.store') }}" method="POST">
                            @csrf
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="productname">Company Name <span class="text-danger">*</span></label>
                                    <input id="productname" name="companyname" type="text" class="form-control companyname @error('companyname') is-invalid @enderror" value="{{ old('companyname') }}" placeholder="Company Name">
                                    @error('companyname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Invoice No Name <span class="text-danger">*</span></label>
                                    <input id="productname" name="inv_no_name" type="text" class="form-control inv_no_name @error('inv_no_name') is-invalid @enderror" value="{{ old('inv_no_name') }}" placeholder="Invoice No Name">
                                    @error('inv_no_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="manufacturername">Email</label>
                                    <input id="manufacturername" name="email" type="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">PAN Number <span class="text-danger">*</span></label>
                                    <input id="productname" name="pannumber" type="text" class="form-control pannumber @error('pannumber') is-invalid @enderror" value="{{ old('pannumber') }}" placeholder="PAN Number">
                                    @error('pannumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6 col-md-4">
                                    <label for="manufacturername">Vendor Code</label>
                                    <input id="manufacturername" name="vendor_code" type="text" class="form-control" value="{{ old('vendor_code') }}" placeholder="Vendor Code">
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="manufacturername">Mobile Number</label>
                                    <input id="manufacturername" name="phone" type="tel" class="form-control" value="{{ old('phone') }}" placeholder="Mobile Number">
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">State <span class="text-danger">*</span></label>
                                    <input id="productname" name="state" type="text" class="form-control state @error('state') is-invalid @enderror" value="{{ old('state') }}" placeholder="State">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="manufacturerbrand">Address 1 <span class="text-danger">*</span></label>
                                    <textarea class="form-control address_1 @error('address_1') is-invalid @enderror" name="address_1" id="" cols="30" rows="4">{{ old('address_1') }}</textarea>
                                    @error('address_1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6 col-md-4">
                                    <label for="manufacturerbrand">Address 2 <span class="text-danger">*</span></label>
                                    <textarea class="form-control address_2 @error('address_2') is-invalid @enderror" name="address_2" id="" cols="30" rows="4">{{ old('address_2') }}</textarea>
                                    @error('address_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="manufacturerbrand">Address 3</label>
                                    <textarea class="form-control" name="address_3" id="" cols="30" rows="4">{{ old('address_3') }}</textarea>
                                </div>
                                <div class="col-6 col-md-4 mt-3">
                                    <label for="is_lut">Is LUT <span class="text-danger">*</span></label>
                                    <input id="is_lut" name="is_lut" type="radio" class="form-check-input @error('is_lut') is-invalid @enderror" value="1" {{ old('is_lut') == '1' ? 'checked' : '' }}>
                                    @error('is_lut')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6 col-md-4 lut_no">
                                    <label for="productname">LUT No <span class="text-danger">*</span></label>
                                    <input id="productname" name="lut_no" type="text" class="form-control lut_no @error('lut_no') is-invalid @enderror" value="{{ old('lut_no') }}" placeholder="LUT NO">
                                    @error('lut_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4 doa">
                                    <label for="productname">DOA <span class="text-danger">*</span></label>
                                    <input id="productname" name="doa" type="date" class="form-control doa @error('doa') is-invalid @enderror" value="{{ old('doa') }}" placeholder="DOA">
                                    @error('doa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">GST Number <span class="text-danger">*</span></label>
                                    <div id="gst-container">
                                        <div class="gst-input-group" style="display: flex;">
                                            <input name="gstnumber[]"
                                                   style="margin-right: 8px;"
                                                   type="text"
                                                   class="form-control gstnumber @error('gstnumber') is-invalid @enderror"
                                                   value="{{ old('gstnumber.0') }}"
                                                   placeholder="GST Number">
                                            <button type="button" class="btn btn-info add-gst">+</button>
                                        </div>
                                    </div>
                                </div>
                                @error('gstnumber')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div id="invoiceCount" class="text-danger"></div>
                                        <div data-repeater-list="group-a" id="dynamicAddRemove">
                                            <div data-repeater-item class="row mb-2" style="padding: 6px">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->getMessages() as $key => $messages)
                                                                @if (preg_match('/\.\d+$/', $key))
                                                                    @foreach ($messages as $message)
                                                                        <li>{{ $message }}</li>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr No.</th>
                                                            <th>Order No. <span class="text-danger">*</span></th>
                                                            <th>Service Code <span class="text-danger">*</span></th>
                                                            <th>Job Description <span class="text-danger">*</span></th>
                                                            <th>UOM <span class="text-danger">*</span></th>
                                                            <th>Price <span class="text-danger">*</span></th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="addMultipleService">
                                                        @if(old('service_code'))
                                                            @foreach(old('service_code') as $index => $service_code)
                                                                <tr>
                                                                    <td class="mb-3 col-lg-1" style="width: 5%;">
                                                                        <input type="text" style="text-align: center;" id="sr_no" name="sr_no[]" class="form-control sr_no" value="{{ $index + 1 }}" readonly />
                                                                    </td>
                                                                    <td class="mb-3 col-lg-3" style="width: 6%;">
                                                                        <input type="text" id="order_no" name="order_no[]" class="form-control order_no @error('order_no.' . $index) is-invalid @enderror" value="{{ old('order_no.' . $index) }}" placeholder="Order No" />
                                                                        @error('order_no.' . $index)
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </td>
                                                                    <td class="mb-3 col-lg-3" style="width: 12%;">
                                                                        <input type="text" id="service_code" name="service_code[]" class="form-control service_code @error('service_code.' . $index) is-invalid @enderror" value="{{ old('service_code.' . $index) }}" placeholder="Service Code" />
                                                                        @error('service_code.' . $index)
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </td>
                                                                    <td class="mb-3 col-lg-3" style="width: 19%;">
                                                                        <textarea id="job_description" name="job_description[]" class="form-control job_description @error('job_description.' . $index) is-invalid @enderror" placeholder="Job Description">{{ old('job_description.' . $index) }}</textarea>
                                                                        @error('job_description.' . $index)
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </td>
                                                                    <td class="mb-3 col-lg-1">
                                                                        <input type="text" id="uom" name="uom[]" class="form-control uom @error('uom.' . $index) is-invalid @enderror" value="{{ old('uom.' . $index) }}" placeholder="UOM" />
                                                                        @error('uom.' . $index)
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </td>
                                                                    <td class="mb-3 col-lg-1">
                                                                        <input type="text" id="price" name="price[]" class="form-control price @error('price.' . $index) is-invalid @enderror" value="{{ old('price.' . $index) }}" placeholder="Price" />
                                                                        @error('price.' . $index)
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </td>
                                                                    <td class="mb-3 col-lg-1" style="width: 0%;">
                                                                        @if($index === 0)
                                                                            <input data-repeater-create type="button" id="addService" class="btn btn-info addService mt-5 mt-lg-0" value="+" />
                                                                        @else
                                                                            <a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td class="mb-3 col-lg-1" style="width: 5%;"><input type="text" style="text-align: center;" id="sr_no" name="sr_no[]" class="form-control sr_no" value="1" readonly /></td>
                                                                <td class="mb-3 col-lg-3" style="width: 6%;"><input type="text" id="order_no" name="order_no[]" class="form-control order_no" value="" placeholder="Order No" /></td>
                                                                <td class="mb-3 col-lg-3" style="width: 12%;"><input type="text" id="service_code" name="service_code[]" class="form-control service_code" value="" placeholder="Service Code" /></td>
                                                                <td class="mb-3 col-lg-3" style="width: 19%;"><textarea id="job_description" name="job_description[]" class="form-control job_description" placeholder="Job Description"></textarea></td>
                                                                <td class="mb-3 col-lg-1"><input type="text" id="uom" name="uom[]" class="form-control uom" value="" placeholder="UOM" /></td>
                                                                <td class="mb-3 col-lg-1"><input type="text" id="price" name="price[]" class="form-control price" value="" placeholder="Price" /></td>
                                                                <td class="mb-3 col-lg-1" style="width: 0%;"><input data-repeater-create type="button" id="addService" class="btn btn-info addService mt-5 mt-lg-0" value="+" /></td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Add Register Company</button>
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
    function updateRowNumbers() {
        $('.addMultipleService tr').each(function(index) {
            $(this).find('.sr_no').val(index + 1);
        });
    }

    $(document).on('click', '.addService', function() {
        var numberofrow = ($('.addMultipleService tr').length - 0) + 1;
        var tr =`
            <tr>
                <td class="mb-3 col-lg-1" style="width: 5%;">
                    <input type="text" style="text-align: center;" id="sr_no" name="sr_no[]" class="form-control sr_no" value="1" readonly />
                </td>
                <td class="mb-3 col-lg-3" style="width: 6%;">
                    <input type="text" id="order_no" name="order_no[]" class="form-control order_no" value="" placeholder="Order No" />
                </td>
                <td class="mb-3 col-lg-3" style="width: 12%;">
                    <input type="text" id="service_code" name="service_code[]" class="form-control service_code" value="" placeholder="Service Code" />
                </td>
                <td class="mb-3 col-lg-3" style="width: 19%;">
                    <textarea type="text" id="description" name="job_description[]" class="form-control job_description" value="" placeholder="Job Description" ></textarea>
                </td>
                <td class="mb-3 col-lg-1">
                    <input type="text" id="uom" name="uom[]" class="form-control uom" value="" placeholder="UOM" />
                </td>
                <td class="mb-3 col-lg-1">
                    <input type="text" id="price" name="price[]" class="form-control price" value="" placeholder="Price" />
                </td>
                <td class="mb-3 col-lg-1" style="width: 0%;"><a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a></td>
            </tr>`;
        $('.addMultipleService').append(tr);
        updateRowNumbers();
    });

    // Delete a row
    $(document).on('click', '.remove-input-field', function() {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });

    $(document).ready(function() {
        $(document).on("click", ".add-gst", function() {
            $("#gst-container").append(`
                <div class="gst-input-group mt-2" style="display: flex;">
                    <input name="gstnumber[]" style="margin-right: 8px;" type="text" class="form-control gstnumber" placeholder="GST Number">
                    <button type="button" class="btn btn-danger remove-gst">-</button>
                </div>
            `);
        });

        $(document).on("click", ".remove-gst", function() {
            $(this).closest(".gst-input-group").remove();
        });
    });


$(document).ready(function () {
    $('#registerCompanyForm').on('submit', function (e) {
        let isValid = true;

        // Clear previous error messages
        $('.invalid-feedback').remove();

        // Function to trim and validate input fields
        function validateField(selector, message) {
            let inputField = $(selector);
            let trimmedValue = $.trim(inputField.val());

            if (trimmedValue === '') {
                isValid = false;
                inputField.addClass('is-invalid').after(`<div class="invalid-feedback">${message}</div>`);
            } else {
                inputField.removeClass('is-invalid');
                inputField.val(trimmedValue); // Update field with trimmed value
            }
        }

        // Validate company name
        validateField('.companyname', 'Please select a company name.');

        // Validate Invoice Number Name
        validateField('.inv_no_name', 'Please enter an Invoice Number Name.');

        // Validate GST Number
        validateField('.gstnumber', 'Please enter a GST Number.');

        // Validate PAN Number
        validateField('.pannumber', 'Please enter a PAN Number.');

        // Validate State
        validateField('.state', 'Please enter a State.');

        // Validate Address 1
        validateField('.address_1', 'Please enter Address 1.');

        // Validate Address 2
        validateField('.address_2', 'Please enter Address 2.');

        // Validate service code and job-related fields
        $('.order_no, .service_code, .job_description, .uom').each(function () {
            validateField(this, `Please enter ${$(this).attr('name')}.`);
        });

        // Validate Price (Numeric and Non-Negative)
        $('.price').each(function () {
            let inputField = $(this);
            let trimmedValue = $.trim(inputField.val());

            if (trimmedValue === '' || isNaN(trimmedValue) || parseFloat(trimmedValue) < 0) {
                isValid = false;
                inputField.addClass('is-invalid').after('<div class="invalid-feedback">Please enter a valid Price.</div>');
            } else {
                inputField.removeClass('is-invalid');
                inputField.val(trimmedValue); // Trim and update value
            }
        });

        // Prevent form submission if not valid
        if (!isValid) {
            e.preventDefault();
        }
    });
});


    $(document).ready(function () {
        $(document).on("blur", ".gstnumber, .pannumber", function () {
            let inputField = $(this);
            let fieldValue = inputField.val();

            // Get the field name, removing [] if it's an array input
            let fieldType = inputField.attr("name").replace(/\[\]$/, "");

            if (fieldValue !== "") {
                $.ajax({
                    url: "{{ route('check.unique') }}", // Ensure this route exists in Laravel
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        fieldType: fieldType,
                        fieldValue: fieldValue
                    },
                    success: function (response) {
                        inputField.next(".invalid-feedback").remove();
                        if (response.exists) {
                            inputField.addClass("is-invalid");
                            inputField.after('<div class="invalid-feedback">' + response.message + "</div>");
                        } else {
                            inputField.removeClass("is-invalid");
                        }
                    }
                });
            } else {
                inputField.removeClass("is-invalid");
                inputField.next(".invalid-feedback").remove();
            }
        });
    });


    $(document).ready(function () {
        function toggleLutFields() {
            if ($('#is_lut').is(':checked')) {
                $('.lut_no').show();
                $('.doa').show();
            } else {
                $('.lut_no').hide();
                $('.doa').hide();
            }
        }

        // Run on page load (if old value exists)
        toggleLutFields();

        // Run on change
        $('#is_lut').on('change', function () {
            toggleLutFields();
        });
    });



</script>
@endsection
