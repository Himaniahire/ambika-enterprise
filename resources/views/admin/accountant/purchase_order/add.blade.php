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
                            Add Purchase Order
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-primary" href="{{route('purchase_order.index')}}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Purchase Orders List
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
                    <div class="card-header">Purchase Order Details</div>
                    <div class="card-body">
                        <form id="poForm" action="{{ route('purchase_order.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-4">
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
                                <div class="col-6 col-md-4" id="inputContainer">
                                    <label class="small mb-1" for="inputFirstName">PO No. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('po_no') is-invalid @enderror" id="po_no" name="po_no" value="{{ old('po_no') }}">
                                    @error('po_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="small mb-1" for="inputFirstName">PO Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('po_date') is-invalid @enderror" id="po_date" name="po_date" value="{{ old('po_date') }}">
                                    @error('po_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="small mb-1" for="inputFirstName">Unit</label>
                                    <input class="form-control" id="inputFirstName" type="text" name="com_unit" value="" placeholder="Company Unit" />
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="small mb-1" for="inputFirstName">Plant</label>
                                    <input class="form-control" id="inputFirstName" type="text" name="plant" value="" placeholder="Plant" />
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="small mb-1" for="inputFirstName">Department</label>
                                    <input class="form-control" id="inputFirstName" type="text" name="department" value="" placeholder="Department" />
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="small mb-1" for="inputFirstName">Contact Name</label>
                                    <input class="form-control" id="inputFirstName" type="text" name="contact_name" value="" placeholder="Contact Name" />
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="small mb-1" for="inputFirstName">Contact Number</label>
                                    <input class="form-control" id="inputFirstName" type="text" name="contact_num" value="" placeholder="Contact Number" />
                                </div>

                                <div class="row mt-3">
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

                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr No.</th>
                                                            <th>Product Name/Code <span class="text-danger">*</span></th>
                                                            <th>Description</th>
                                                            <th>HSN/SAC Code</th>
                                                            <th>UOM</th>
                                                            <th>Price</th>
                                                            <th>Qty <span class="text-danger">*</span></th>
                                                            <th>Amount Rs.</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="addMultiplePO">
                                                        @if(old('service_code'))
                                                            @foreach(old('service_code') as $index => $service_code)
                                                                <tr>
                                                                    <td class="mb-3 col-lg-1" style="width: 5%;">
                                                                        <input type="text" style="text-align: center;" id="sr_no" name="sr_no[]" class="form-control sr_no" value="{{ $index + 1 }}" readonly />
                                                                    </td>
                                                                    <td class="mb-3 col-lg-3" style="width: 12%;">
                                                                        <select class="form-control service_code_id mb-3 @error('service_code.' . $index) is-invalid @enderror" name="service_code[]" id="service_code_id">
                                                                            <option value="">Select Service Code</option>
                                                                            <!-- Populate options dynamically here -->
                                                                        </select>
                                                                        @error('service_code.' . $index)
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </td>
                                                                    <td class="mb-3 col-lg-3" style="width: 19%;">
                                                                        <textarea type="text" id="job_description" name="job_description[]" class="form-control job_description" placeholder="Job Description" readonly>{{ old('job_description.' . $index) }}</textarea>
                                                                    </td>
                                                                    <td class="mb-3 col-lg-1">
                                                                        <input type="text" id="hsn_sac_code" name="hsn_sac_code[]" class="form-control hsn_sac_code" placeholder="HSN/SAC Code" value="{{ old('hsn_sac_code.' . $index) }}" />
                                                                    </td>
                                                                    <td class="mb-3 col-lg-1">
                                                                        <input type="text" id="uom" name="uom[]" class="form-control uom" placeholder="UOM" readonly value="{{ old('uom.' . $index) }}" />
                                                                    </td>
                                                                    <td class="mb-3 col-lg-1">
                                                                        <input type="text" id="price" name="price[]" class="form-control price" placeholder="Price" readonly value="{{ old('price.' . $index) }}" />
                                                                    </td>
                                                                    <td class="mb-3 col-lg-1">
                                                                        <input type="text" id="qty" name="qty[]" class="form-control qty @error('qty.' . $index) is-invalid @enderror" placeholder="Qty" value="{{ old('qty.' . $index) }}" />
                                                                        @error('qty.' . $index)
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </td>
                                                                    <td class="mb-3 col-lg-2" style="width: 7%;">
                                                                        <input type="text" id="total_amount" name="total_amount[]" class="form-control total_amount" placeholder="Amount" readonly value="{{ old('total_amount.' . $index) }}" />
                                                                    </td>
                                                                    <td class="mb-3 col-lg-1" style="width: 0%;">
                                                                        @if($index === 0)
                                                                            <td class="mb-3 col-lg-1" style="width: 0%;"><input data-repeater-create type="button" id="addPO" class="btn btn-info addPO mt-5 mt-lg-0" value="+" /></td>
                                                                        @else
                                                                            <a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td class="mb-3 col-lg-1" style="width: 5%;"><input type="text" style="text-align: center;" id="sr_no" name="sr_no[]" class="form-control sr_no" value="1" readonly /></td>
                                                                <td class="mb-3 col-lg-3" style="width: 12%;"><select class="form-control service_code_id mb-3" name="service_code[]" id="service_code_id"><option value="">Select Service Code</option></select></td>
                                                                <td class="mb-3 col-lg-3" style="width: 19%;"><textarea type="text" id="job_description" name="job_description[]" class="form-control job_description" placeholder="Job Description" readonly></textarea></td>
                                                                <td class="mb-3 col-lg-1"><input type="text" id="hsn_sac_code" name="hsn_sac_code[]" class="form-control hsn_sac_code" placeholder="HSN/SAC Code" /></td>
                                                                <td class="mb-3 col-lg-1"><input type="text" id="uom" name="uom[]" class="form-control uom" placeholder="UOM" readonly /></td>
                                                                <td class="mb-3 col-lg-1"><input type="text" id="price" name="price[]" class="form-control price" placeholder="Price" readonly /></td>
                                                                <td class="mb-3 col-lg-1"><input type="text" id="qty" name="qty[]" class="form-control qty" placeholder="Qty" /></td>
                                                                <td class="mb-3 col-lg-2" style="width: 7%;"><input type="text" id="total_amount" name="total_amount[]" class="form-control total_amount" placeholder="Amount" readonly /></td>
                                                                <td class="mb-3 col-lg-1" style="width: 0%;"><input data-repeater-create type="button" id="addPO" class="btn btn-info addPO mt-5 mt-lg-0" value="+" /></td>
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
                                <div class="col-6 col-md-12" style="padding:0px 130px;">
                                    <label class="small mb-1" for="inputFirstName" style="font-size: 19px;font-weight: bold;float: right">Total Amount: <span style="float: right; padding: 0px 0px 0px 20px;" class="total" id="total" type="text" name="total"></span></label>

                                    <input style="float: right" class="form-control" id="inputFirstName" type="hidden" name="total"   />
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Add PO</button>
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

        $('#company_id').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ route('get.service.codes', ':id') }}".replace(':id', companyId),
                    type: 'GET',
                    success: function(data) {
                        $('.service_code_id').empty().append('<option value="">Select Service</option>');
                        $.each(data, function(index, service) {
                            $('.service_code_id').append('<option value="' + service.id + '">' + service.service_code + '</option>');
                        });
                    }
                });
            }
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
                    row.find('.price').val(data.price);
                }
            });
        } else {
            row.find('.job_description').val('');
            row.find('.uom').val('');
            row.find('.price').val('');
        }
    });

    $(document).ready(function() {

        function TotalAmount() {
            // I will make all the Logic here
            var total = 0;
            $('.total_amount').each(function(i, e) {
                var amount = parseFloat($(this).val()) || 0;
                total += amount;
            });
            $('.total').html(total.toFixed(2));
        }

        // Function to update row numbers
        function updateRowNumbers() {
            $('.addMultiplePO tr').each(function(index) {
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
                        $(selectElement).append('<option value="' + service.id + '">' + service.service_code + '</option>');
                    });
                }
            });
        }

        // Add a new row when the addSummary button is clicked
        $('.addPO').on('click', function() {
            var numberofrow = ($('.addMultiplePO tr').length - 0) + 1;
            var tr =`
                        <tr>
                            <td class="mb-3 col-lg-1" style="width: 5%;"><input type="text" id="sr_no" name="sr_no[]" class="form-control sr_no" value="` + numberofrow + `" readonly /></td>
                            <td class="mb-3 col-lg-3" style="width: 12%;">
                                <select class="form-control service_code_id mb-3" name="service_code[]" id="service_code_id">
                                    <option value="">Select Service Code</option>
                                </select>
                            </td>
                            <td class="mb-3 col-lg-3" style="width: 19%;"><textarea type="text" id="job_description" name="job_description[]" class="form-control job_description" placeholder="Job Description" readonly></textarea></td>
                            <td class="mb-3 col-lg-1"><input type="text" id="hsn_sac_code" name="hsn_sac_code[]" class="form-control hsn_sac_code" placeholder="HSN/SAC Code" /></td>
                            <td class="mb-3 col-lg-1"><input type="text" id="uom" name="uom[]" class="form-control uom" placeholder="UOM" readonly /></td>
                            <td class="mb-3 col-lg-1"><input type="text" id="price" name="price[]" class="form-control price" placeholder="Price" readonly /></td>
                            <td class="mb-3 col-lg-1"><input type="text" id="qty" name="qty[]" class="form-control qty" placeholder="Qty" />
                            </td>
                            <td class="mb-3 col-lg-2" style="width: 7%;"><input type="text" id="total_amount" name="total_amount[]" class="form-control total_amount" placeholder="Amount" readonly /></td>
                            <td class="mb-3 col-lg-1" style="width: 0%;"><a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a></td>
                        </tr>`;
            $('.addMultiplePO').append(tr);

            updateRowNumbers();

            // Populate the service code dropdown based on the selected company_id or po_no_id
            var selectElement = $('.addMultiplePO tr:last .service_code_id');
            var companyId = $('#company_id').val();

            if (companyId) {
                // Only companyId is defined
                fetchAndPopulateServiceCodesByCompanyId(selectElement, companyId);
            }

            TotalAmount();

        });

        // Delete a row
        $('.addMultiplePO').delegate('.remove-input-field', 'click ', function() {
            $(this).parent().parent().remove();
            updateRowNumbers();
            TotalAmount();
        });

        $('.addMultiplePO').on('keyup', '#qty, #price', function() {
            var tr = $(this).closest('tr');
            var qty = parseFloat(tr.find('#qty').val()) || 0;
            var price = parseFloat(tr.find('#price').val()) || 0;
            var total_amount = qty * price;
            total_amount = total_amount.toFixed(2);
            tr.find('#total_amount').val(total_amount);
            TotalAmount();
        });
    });

    $(document).ready(function () {
        $('#poForm').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.invalid-feedback').remove();

            // Validate company name
            if ($('#company_id').val() === '') {
                isValid = false;
                $('#company_id').addClass('is-invalid').after('<div class="invalid-feedback">Please select a company name.</div>');
            } else {
                $('#company_id').removeClass('is-invalid');
            }

            // Validate PO number
            if ($('#po_no').val().trim() === '') {
                isValid = false;
                $('#po_no').addClass('is-invalid').after('<div class="invalid-feedback">Please enter a PO number.</div>');
            } else {
                $('#po_no').removeClass('is-invalid');
            }

            // Validate PO date
            if ($('#po_date').val().trim() === '') {
                isValid = false;
                $('#po_date').addClass('is-invalid').after('<div class="invalid-feedback">Please enter a PO date.</div>');
            } else {
                $('#po_date').removeClass('is-invalid');
            }

            // Validate service code and qty
            $('.service_code_id').each(function (index, element) {
                if ($(element).val() === '') {
                    isValid = false;
                    $(element).addClass('is-invalid').after('<div class="invalid-feedback">Please select a service code.</div>');
                } else {
                    $(element).removeClass('is-invalid');
                }
            });

            $('.qty').each(function (index, element) {
                if ($(element).val().trim() === '' || isNaN($(element).val()) || parseFloat($(element).val()) < 0) {
                    isValid = false;
                    $(element).addClass('is-invalid').after('<div class="invalid-feedback">Please enter a valid quantity.</div>');
                } else {
                    $(element).removeClass('is-invalid');
                }
            });

            // Prevent form submission if not valid
            if (!isValid) {
                e.preventDefault();
            }
        });
    });


</script>

@endsection
