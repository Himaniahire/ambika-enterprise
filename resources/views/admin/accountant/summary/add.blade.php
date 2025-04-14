@extends('admin.layouts.layout')
@section('content')

<style>
    .error {
        color: red;
    }
    .multi-error {
        color: red;
    }
</style>
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                                Add Summary
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-primary" href="{{ route('summary.index') }}" >
                                <i class="me-1" data-feather="arrow-left"></i>
                                Back to Summaries List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content -->
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Account details card -->
                    <div class="card mb-4">
                        <div class="card-header">Summary Details</div>
                        <div class="card-body">
                            <form id="summaryForm" action="{{ route('summary.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <input class="form-control" id="inputFirstName" type="hidden" name="order_no"
                                        value="" />
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Company Name <span class="text-danger">*</span></label>
                                        <select class="form-control company_name @error('company_name') is-invalid @enderror" id="company_id" name="company_name">
                                            <option value="">Select Company Name</option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}" {{ old('company_name') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->companyname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">GST Number</label>
                                        <select class="form-control gstSelect" style="display:none;" id="gstSelect" name="gst_id">
                                            <option value="">Select GST Number</option>
                                        </select>
                                        <div id="noPoMessage" style="display:none;color:red;">There is no GST Number available.</div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">PO Number</label>
                                        <select class="form-control poSelect" style="display:none;" id="poSelect" name="po_no_id">
                                            <option value="">Select Purchase Order</option>
                                        </select>
                                        <div id="noPoMessage" style="display:none;color:red;">There is no PO available.</div>
                                    </div>
                                    <div class="col-4 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Summary Duration <span class="text-danger">*</span></label>
                                        <input type="text" name="summary_duration" id="summary_duration" class="form-control @error('summary_duration') is-invalid @enderror" value="{{ old('summary_duration') }}" placeholder="" />
                                        @error('summary_duration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Summary No <span class="text-danger">*</span></label>
                                        <input type="text" id="sum_no" name="sum_no" class="form-control" value=""
                                        @if(auth()->user()->role_id == 1)
                                        @removeReadonly
                                    @else
                                        readonly
                                    @endif placeholder="Summary No" />
                                    </div>
                                    <div class="col-4 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Company Unit</label>
                                        <input type="text" name="com_unit" class="form-control" value=""
                                            placeholder="Company Unit" />
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Plant</label>
                                        <input type="text" name="plant" class="form-control" value=""
                                            placeholder="Plant" />
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Department</label>
                                        <input type="text" name="department" class="form-control" value=""
                                            placeholder="Department" />
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Category Of Services <span class="text-danger">*</span></label>
                                        <select class="form-control @error('category_of_service') is-invalid @enderror" id="category_of_service_id" name="category_of_service">
                                            <option value="">Select</option>
                                            @foreach ($categoryOfService as $item)
                                                 <option value="{{ $item->id }}" {{ old('category_of_service') == $item->id ? 'selected' : '' }}>{{ $item->category_of_service }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_of_service')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-md-3" id="inputContainer">
                                        <label class="small mb-1" for="inputFirstName">Work Period <span class="text-danger">*</span></label>
                                        <input class="form-control  @error('work_period') is-invalid @enderror" type="text" name="work_period" id="work_period"  value="{{ old('work_period') }}"/>
                                        @error('work_period')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">JMR No</label>
                                        <input class="form-control" id="jmr_no" type="text" name="jmr_no" value="" />
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Capex No</label>
                                        <input class="form-control" id="capex_no" type="text" name="capex_no" value="" />
                                    </div>
                                    <div class="col-6 col-md-3" id="inputContainer">
                                        <label class="small mb-1" for="inputFirstName">Work/Contract Order No</label>
                                        <input class="form-control" type="text" name="work_contract_order_no" id="work_contract_order_no" value=""/>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-12">
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


                                                    <table class="table" id="jobDescriptionContainer">
                                                        <span id="multi-error-message" class="multi-error"></span>
                                                        <thead>
                                                            <tr>
                                                                <th>Date <span class="text-danger">*</span></th>
                                                                <th>Pg No.</th>
                                                                <th>Sr No.</th>
                                                                <th>Service code<span class="text-danger">*</span></th>
                                                                <th>Job Description</th>
                                                                <th>Length <span class="text-danger">*</span></th>
                                                                <th>Width <span class="text-danger">*</span></th>
                                                                <th>Height <span class="text-danger">*</span></th>
                                                                <th>Nos <span class="text-danger">*</span></th>
                                                                <th>Total Quantity</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="addMultipleSummary">
                                                            @if(old('service_code'))
                                                                @foreach(old('service_code') as $index => $service_code)
                                                                    <tr>
                                                                        <td class="mb-3 col-lg-1" style="width: 12%;">
                                                                            <input type="text" name="sum_date[]"class="form-control sum_date @error('sum_date.' . $index) is-invalid @enderror" value="{{ old('sum_date.' . $index) }}" placeholder="DD-MM-YYYY" />
                                                                            @error('sum_date.' . $index)
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        <td class="mb-3 col-lg-1" style="width: 6%;"><input type="text" style="text-align: center;" name="pg_no[]" class="form-control pg_no" value="" placeholder="Pg No." /></td>
                                                                        <td class="mb-3 col-lg-1" style="width: 5%;"><input type="text" style="text-align: center;" name="sr_no[]" class="form-control sr_no" value="1" readonly /></td>
                                                                        <td class="mb-3 col-lg-3" style="width: 12%;">
                                                                            <select class="form-control service_code_id mb-3 @error('service_code.' . $index) is-invalid @enderror" name="service_code_id[]" id="service_code_id">
                                                                                <option value="">Select Service Code</option>
                                                                                <!-- Populate options dynamically here -->
                                                                            </select>
                                                                            @error('service_code.' . $index)
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </td>
                                                                        <td class="mb-3 col-lg-3"><input type="text" name="job_description[]" class="form-control job_description" value="" placeholder="Job Description" readonly /></td>
                                                                        <td class="mb-3 col-lg-1" style="width: 7%;">
                                                                            <input type="text" name="length[]" class="form-control length @error('length.' . $index) is-invalid @enderror" value="{{ old('length.' . $index) }}" placeholder="Length" />
                                                                            @error('length.' . $index)
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </td>
                                                                        <td class="mb-3 col-lg-1" style="width: 7%;">
                                                                            <input type="text" name="width[]" class="form-control width @error('width.' . $index) is-invalid @enderror" value="{{ old('width.' . $index) }}" placeholder="Width" />
                                                                            @error('width.' . $index)
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </td>
                                                                        <td class="mb-3 col-lg-1" style="width: 7%;">
                                                                            <input type="text" name="height[]" class="form-control height @error('height.' . $index) is-invalid @enderror" value="{{ old('height.' . $index) }}" placeholder="Height" />
                                                                            @error('height.' . $index)
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </td>
                                                                        <td class="mb-3 col-lg-1" style="width: 7%;">
                                                                            <input type="text" name="nos[]" class="form-control nos @error('nos.' . $index) is-invalid @enderror" value="{{ old('nos.' . $index) }}" placeholder="Nos" />
                                                                            @error('nos.' . $index)
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </td>
                                                                        <td class="mb-3 col-lg-2" style="width: 9%;"><input type="text" name="total_qty[]" class="form-control total_qty" value="" placeholder="Quantity" readonly /></td>
                                                                        <td class="mb-3 col-lg-1">
                                                                            @if($index === 0)
                                                                                <input data-repeater-create type="button" id="addSummary" class="btn btn-info addSummary mt-5 mt-lg-0" value="+" />
                                                                            @else
                                                                                <a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td class="mb-3 col-lg-1" style="width: 12%;"><input type="text" name="sum_date[]"class="form-control sum_date" value="" placeholder="DD-MM-YYYY" /></td>
                                                                    <td class="mb-3 col-lg-1" style="width: 6%;"><input type="text" style="text-align: center;" name="pg_no[]" class="form-control pg_no" value="" placeholder="Pg No." /></td>
                                                                    <td class="mb-3 col-lg-1" style="width: 5%;"><input type="text" style="text-align: center;" name="sr_no[]" class="form-control sr_no" value="1" readonly /></td>
                                                                    <td style="width: 12%;">
                                                                        <select class="form-control service_code_id" name="service_code_id[]" id="service_code_id">
                                                                            <option value="">Select Service Code</option>
                                                                        </select>
                                                                        <input type="hidden" name="service_code[]" class="service_code_input">
                                                                    </td>
                                                                    <td class="mb-3 col-lg-3"><input type="text" name="job_description[]" class="form-control job_description" value="" placeholder="Job Description" readonly /><input type="hidden" name="uom[]" class="form-control uom" readonly/></td>
                                                                    <td class="mb-3 col-lg-1" style="width: 7%;"><input type="text" name="length[]" class="form-control length" value="" placeholder="Length" /></td>
                                                                    <td class="mb-3 col-lg-1" style="width: 7%;"><input type="text" name="width[]" class="form-control width" value="" placeholder="Width" /></td>
                                                                    <td class="mb-3 col-lg-1" style="width: 7%;"><input type="text" name="height[]" class="form-control height" value="" placeholder="Height" /></td>
                                                                    <td class="mb-3 col-lg-1" style="width: 7%;"><input type="text" name="nos[]" class="form-control nos" value="" placeholder="Nos" /></td>
                                                                    <td class="mb-3 col-lg-2" style="width: 9%;"><input type="text" name="total_qty[]" class="form-control total_qty" value="" placeholder="Quantity" readonly /></td>
                                                                    <td class="mb-3 col-lg-1"><input data-repeater-create type="button" id="addSummary" class="btn btn-info addSummary mt-5 mt-lg-0" value="+" /></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Document</label>
                                        <input class="form-control" type="file" name="document" id="">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="small mb-1" for="inputFirstName">Total Quantity</label>
                                        <h5 class="total" id="total" type="text" name="total"></h5>
                                        <input class="form-control total" id="inputFirstName" type="hidden"
                                            name="total" placeholder="RS.0" />
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Add Summary</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('footer-script')
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<!--<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>-->

<script>

    // $(document).ready(function() {
    //     $('#dateInput').on('input', function() {
    //         var dateInput = $(this).val();
    //         var datePattern = /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/;

    //         if (datePattern.test(dateInput)) {
    //             $('#error-message').text('');
    //         } else {
    //             $('#error-message').text('Invalid format. Please use DD-MM-YYYY.');
    //         }
    //     });
    // });

    // $(document).ready(function() {
    //     $('.sum_date').on('input', function() {
    //         var dateInput = $(this).val();
    //         var datePattern = /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/;

    //         if (datePattern.test(dateInput)) {
    //             $('.multi-error').text('');
    //         } else {
    //             $('.multi-error').text('Invalid. Please use DD-MM-YYYY.');
    //         }
    //     });
    // });

    $(document).ready(function() {
    //     // Handle company selection
    //     $('#company_id').change(function() {
    //         var companyId = $(this).val();
    //         var currentYear = new Date().getFullYear();
    //         var nextYear = currentYear + 1;
    //         var lastTwoDigitsCurrentYear = String(currentYear).slice(-2);
    //         var lastTwoDigitsNextYear = String(nextYear).slice(-2);
    //         // Send AJAX request to fetch invoice number name
    //         $.ajax({
    //             url: "{{ route('get-summary-number') }}",
    //             method: 'GET',
    //             data: { company_id: companyId },
    //             success: function(response) {
    //                 // Populate invoice number name input with fetched data
    //                 $('#sum_no').val(lastTwoDigitsCurrentYear + '-' + lastTwoDigitsNextYear + '/' + response.inv_no_name + '/' + 'SUM');
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error(error);
    //             }
    //         });
    //     });

        $('#company_id').change(function() {
            var companyId = $(this).val();
            $.ajax({
                url: "{{ route('purchase-orders', ['companyId']) }}".replace('companyId', companyId),
                type: 'GET',
                success: function(response) {
                    var purchaseOrders = response.purchaseOrders;
                    if (purchaseOrders.length > 0) {
                        // Display the purchase order dropdown
                        $('.poSelect').empty().show().append('<option value="">Select Purchase Order</option>');
                        purchaseOrders.forEach(function(po) {
                            $('.poSelect').append('<option value="' + po.id + '">' + po.po_no + '</option>');
                        });
                        $('#noPoMessage').hide();
                    } else {
                        // Clear and hide the product dropdown
                        $('.poSelect').hide();
                        $('#noPoMessage').show(); // Show the no purchase order message
                    }

                }
            });
        });

        $('#company_id').change(function() {
            var companyId = $(this).val();
            $.ajax({
                url: "{{ route('get-gst-numbers', ['companyId']) }}".replace('companyId', companyId),
                type: 'GET',
                success: function(response) {
                    var gstNumbers = response.gstNumbers;
                    if (gstNumbers.length > 0) {
                        // Display the GST dropdown
                        $('.gstSelect').empty().show().append('<option value="">Select GST Number</option>');
                        gstNumbers.forEach(function(gst) {
                            $('.gstSelect').append('<option value="' + gst.id + '">' + gst.gstnumber + '</option>');
                        });
                        $('#noPoMessage').hide();
                    } else {
                        $('.gstSelect').hide();
                        $('#noPoMessage').text("There is no GST Number available.").show();
                    }
                }
            });
        });

    });

    $('#company_id').change(function() {
        var companyId = $(this).val();
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth() + 1; // JavaScript months are 0-based, so add 1

        var startYear, endYear;

        // Determine financial year based on month
        if (currentMonth < 4) {
            startYear = currentYear - 1;
            endYear = currentYear;
        } else {
            startYear = currentYear;
            endYear = currentYear + 1;
        }

        var lastTwoDigitsStartYear = String(startYear).slice(-2);
        var lastTwoDigitsEndYear = String(endYear).slice(-2);

        // Send AJAX request to fetch the latest summary number
        $.ajax({
            url: "{{ route('get-summary-number') }}",
            method: 'GET',
            data: { company_id: companyId },
            success: function(response) {
                if (response.latest_number) {
                    let newNumber = ('00000' + response.latest_number).slice(-5); // Format to 5 digits
                    $('#sum_no').val(lastTwoDigitsStartYear + '-' + lastTwoDigitsEndYear + '/SUM/' + newNumber);
                } else {
                    $('#sum_no').val(lastTwoDigitsStartYear + '-' + lastTwoDigitsEndYear + '/SUM/00001'); // Start from 00001
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });



    $(document).ready(function() {
        // Fetch and populate service codes when the company_id changes
        // $('#company_id').change(function() {
        //     var companyId = $(this).val();
        //     if (companyId) {
        //         $.ajax({
        //             url: "{{ route('get.services', ':id') }}".replace(':id', companyId),
        //             type: 'GET',
        //             success: function(data) {
        //                 $('.service_code_id').empty().append('<option value="">Select Service</option>');
        //                 $.each(data, function(index, service) {
        //                     $('.service_code_id').append('<option value="' + service.id + '">' + service.service_code + '</option>');
        //                 });
        //             }
        //         });
        //     }
        // });

        $('#company_id').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ route('get.services', ':id') }}".replace(':id', companyId),
                    type: 'GET',
                    success: function(data) {
                        $('.service_code_id').empty().append('<option value="">Select Service</option>');
                        $.each(data, function(index, service) {
                            $('.service_code_id').append(
                                '<option value="' + service.id + '" data-service-code="' + service.service_code + '">' + service.service_code + '</option>'
                            );
                        });
                    }
                });
            }
        });

        $(document).on('change', '.service_code_id', function() {
            var selectedOption = $(this).find('option:selected');
            var serviceCode = selectedOption.data('service-code'); // Get the data-service-code value

            // Find the corresponding hidden input in the same row and set its value
            $(this).closest('tr').find('.service_code_input').val(serviceCode);
        });




        // Fetch and populate service codes when the poSelect changes
        $('.poSelect').change(function() {
            var poId = $(this).val();
            if (poId) {
                $.ajax({
                    url: "{{ route('get-service', ':id') }}".replace(':id', poId),
                    type: 'GET',
                    success: function(data) {
                        $('.service_code_id').empty().append('<option value="">Select Service</option>');
                        $.each(data, function(index, service) {
                            $('.service_code_id').append('<option value="' + service.id + '" data-service-code="' + service.service_code + '">' + service.service_code + '</option>');
                        });
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        function TotalAmount() {
            var total = 0;
            $('.total_qty').each(function(i, e) {
                var amount = parseFloat($(this).val()) || 0;
                total += amount;
            });
            // Round the total to 2 decimal places and format it as a string
            var rounded_total = parseFloat(total.toFixed(2));
            $('.total').html(rounded_total.toFixed(2));
        }


        // Function to update row numbers
        function updateRowNumbers() {
            $('.addMultipleSummary tr').each(function(index) {
                $(this).find('.sr_no').val(index + 1);
            });
        }

        // Function to fetch and populate service codes for a specific select element based on companyId
        function fetchAndPopulateServiceCodesByCompanyId(selectElement, companyId) {
            $.ajax({
                url: "{{ route('get.services', ':id') }}".replace(':id', companyId),
                type: 'GET',
                success: function(data) {
                    $(selectElement).empty().append('<option value="">Select Service</option>');
                    $.each(data, function(index, service) {
                        $(selectElement).append('<option value="' + service.id + '"data-service-code="' + service.service_code + '">' + service.service_code + '</option>');
                    });
                }
            });
        }

        // Function to fetch and populate service codes for a specific select element based on poId
        function fetchAndPopulateServiceCodesByPoId(selectElement, poId) {
            $.ajax({
                url: "{{ route('get-service', ':id') }}".replace(':id', poId),
                type: 'GET',
                success: function(data) {
                    $(selectElement).empty().append('<option value="">Select Service</option>');
                    $.each(data, function(index, service) {
                        $(selectElement).append('<option value="' + service.id + '"data-service-code="' + service.service_code + '">' + service.service_code + '</option>');
                    });
                }
            });
        }

        // Add a new row when the addSummary button is clicked
        $(document).on('click', '.addSummary', function() {
            var numberofrow = $('.addMultipleSummary tr').length + 1;
            var tr = `
                <tr>
                    <td class="mb-3 col-lg-2" style="width: 12%;"><input type="text" name="sum_date[]"  class="form-control sum_date" placeholder="DD-MM-YYYY" /><span id="error-message" class="multi-error"></span></td>
                    <td class="mb-3 col-lg-1" style="width: 6%;"><input type="text" style="text-align: center;" name="pg_no[]" class="form-control pg_no" placeholder="Pg No." /></td>
                    <td class="mb-3 col-lg-1" style="width: 5%;"><input type="text" style="text-align: center;" name="sr_no[]" class="form-control sr_no" value="` + numberofrow + `" readonly /></td>
                    <td class="mb-3 col-lg-3" style="width: 12%;"><select class="form-control service_code_id" style="height: 36px;" name="service_code_id[]"><option value="">Select Service Code</option></select><input type="hidden" name="service_code[]" class="service_code_input"></td>
                    <td class="mb-3 col-lg-3"><input type="text" name="job_description[]" class="form-control job_description" placeholder="Job Description" readonly/><input type="hidden" name="uom[]" class="form-control uom" readonly/></td>
                    <td class="mb-3 col-lg-1" style="width: 7%;"><input type="text" name="length[]" class="form-control length" placeholder="Length" /></td>
                    <td class="mb-3 col-lg-1" style="width: 7%;"><input type="text" name="width[]" class="form-control width" placeholder="Width" /></td>
                    <td class="mb-3 col-lg-1" style="width: 7%;"><input type="text" name="height[]" class="form-control height" placeholder="Height" /></td>
                    <td class="mb-3 col-lg-1" style="width: 7%;"><input type="text" name="nos[]" class="form-control nos" placeholder="Nos" /></td>
                    <td class="mb-3 col-lg-2" style="width: 9%;"><input type="text" name="total_qty[]" class="form-control total_qty" placeholder="Quantity" readonly /></td>
                    <td class="mb-3 col-lg-1"><a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a></td>
                </tr>`;
            $('.addMultipleSummary').append(tr);
            updateRowNumbers();

            // Populate the service code dropdown based on the selected company_id or po_no_id
            var selectElement = $('.addMultipleSummary tr:last .service_code_id');
            var companyId = $('#company_id').val();
            var poId = $('.poSelect').val();

            if (companyId && poId) {
                // Both companyId and poId are defined
                fetchAndPopulateServiceCodesByPoId(selectElement, poId);
            } else if (companyId) {
                // Only companyId is defined
                fetchAndPopulateServiceCodesByCompanyId(selectElement, companyId);
            }

            TotalAmount();
        });

        // Delete a row
        $(document).on('click', '.remove-input-field', function() {
            $(this).closest('tr').remove();
            updateRowNumbers();
            TotalAmount();
        });

        $('.addMultipleSummary').on('keyup', '.length, .width, .height, .nos', function() {
            var tr = $(this).closest('tr');
            var length = parseFloat(tr.find('.length').val()) || 0;
            var width = parseFloat(tr.find('.width').val()) || 0;
            var height = parseFloat(tr.find('.height').val()) || 0;
            var nos = parseFloat(tr.find('.nos').val()) || 0;
            var total_amount = length * width * height * nos;
            total_amount = total_amount.toFixed(2); // Round to 2 decimal places and keep as string
            tr.find('.total_qty').val(total_amount);
            TotalAmount();
        });

    });

    $(document).on('change', '.service_code_id', function() {
        // Function to fetch Service Code details for each row
        var serviceCodeId = $(this).val();
        var row = $(this).closest('tr');

        if (serviceCodeId) {
            $.ajax({
                url: "{{ route('get.service.code.details', ':id') }}".replace(':id', serviceCodeId),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    row.find('.job_description').val(data.job_description);
                    row.find('.uom').val(data.uom);
                }
            });
        } else {
            row.find('.job_description').val('');
        }
    });

    $(document).ready(function() {
    $('#summaryForm').on('submit', function(event) {
        let isValid = true;

        // Clear previous error messages
        $('.invalid-feedback').remove();

        // Validate Company Name
        if ($('#company_id').val() === '') {
            isValid = false;
            $('#company_id').addClass('is-invalid').after('<div class="invalid-feedback">Please select a company name.</div>');
        } else {
            $('#company_id').removeClass('is-invalid');
        }


        // Validate Summary Duration
        if ($('#summary_duration').val() === '') {
            $('#summary_duration').addClass('is-invalid').after('<div class="invalid-feedback">Summary Duration is required.</div>');
            isValid = false;
        } else {
            $('#summary_duration').removeClass('is-invalid');
        }

        // Validate Category of Services
        if ($('#category_of_service_id').val() === '') {
            $('#category_of_service_id').addClass('is-invalid').after('<div class="invalid-feedback">Category of Services is required.</div>');
            isValid = false;
        } else {
            $('#category_of_service_id').removeClass('is-invalid');
        }

        // Validate Work Period
        if ($('#work_period').val() === '') {
            $('#work_period').addClass('is-invalid').after('<div class="invalid-feedback">Work Period is required.</div>');
            isValid = false;
        } else {
            $('#work_period').removeClass('is-invalid');
        }

        // Validate For MultipleSummary
        if ($('.sum_date').val() === '') {
            $('.sum_date').addClass('is-invalid').after('<div class="invalid-feedback">Summary Date is required.</div>');
            isValid = false;
        } else {
            $('.sum_date').removeClass('is-invalid');
        }

        $('.service_code_id').each(function (index, element) {
            if ($(element).val() === '') {
                isValid = false;
                $(element).addClass('is-invalid').after('<div class="invalid-feedback">Please select a service code.</div>');
            } else {
                $(element).removeClass('is-invalid');
            }
        });

        $('.length').each(function (index, element) {
            if ($(element).val().trim() === '' || isNaN($(element).val()) || parseFloat($(element).val()) < 0) {
                isValid = false;
                $(element).addClass('is-invalid').after('<div class="invalid-feedback">Please enter a valid length.</div>');
            } else {
                $(element).removeClass('is-invalid');
            }
        });

        $('.width').each(function (index, element) {
            if ($(element).val().trim() === '' || isNaN($(element).val()) || parseFloat($(element).val()) < 0) {
                isValid = false;
                $(element).addClass('is-invalid').after('<div class="invalid-feedback">Please enter a valid width.</div>');
            } else {
                $(element).removeClass('is-invalid');
            }
        });

        $('.height').each(function (index, element) {
            if ($(element).val().trim() === '' || isNaN($(element).val()) || parseFloat($(element).val()) < 0) {
                isValid = false;
                $(element).addClass('is-invalid').after('<div class="invalid-feedback">Please enter a valid height.</div>');
            } else {
                $(element).removeClass('is-invalid');
            }
        });

        $('.nos').each(function (index, element) {
            if ($(element).val().trim() === '' || isNaN($(element).val()) || parseFloat($(element).val()) < 0) {
                isValid = false;
                $(element).addClass('is-invalid').after('<div class="invalid-feedback">Please enter a valid nos.</div>');
            } else {
                $(element).removeClass('is-invalid');
            }
        });

        // Prevent form submission if any validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });
});


</script>
@endsection
