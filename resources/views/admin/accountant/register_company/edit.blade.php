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
                            Edit Register Company
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
                        <form action="{{ route('register_company.update', $companies->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="productname">Company Name <span class="text-danger">*</span></label>
                                    <input id="productname" name="companyname" type="text" class="form-control" value="{{$companies->companyname}}" placeholder="Company Name">
                                    @if ($errors->has('companyname'))
                                        <div class="text-danger">{{ $errors->first('companyname') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Invoice No Name <span class="text-danger">*</span></label>
                                    <input id="productname" name="inv_no_name" type="text" class="form-control" value="{{$companies->inv_no_name}}" placeholder="Invoice No Name">
                                    @if ($errors->has('inv_no_name'))
                                        <div class="text-danger">{{ $errors->first('inv_no_name') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="manufacturername">Email</label>
                                    <input id="manufacturername" name="email" type="email" class="form-control" value="{{$companies->email}}" placeholder="Email">
                                    @if ($errors->has('email'))
                                        <div class="text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">PAN Number <span class="text-danger">*</span></label>
                                    <input id="productname" name="pannumber" type="text" class="form-control" value="{{$companies->pannumber}}" placeholder="PAN Number">
                                    @if ($errors->has('pannumber'))
                                        <div class="text-danger">{{ $errors->first('pannumber') }}</div>
                                    @endif
                                </div>
                                {{-- <div class="col-6 col-md-6">
                                    <label for="productname">GST Number <span class="text-danger">*</span></label>
                                    <input id="productname" name="gstnumber" type="text" class="form-control" value="{{$companies->gstnumber}}" placeholder="GST Number">
                                    @if ($errors->has('gstnumber'))
                                        <div class="text-danger">{{ $errors->first('gstnumber') }}</div>
                                    @endif
                                </div> --}}
                                <div class="col-6 col-md-4">
                                    <label for="productname">Vendor Code <span class="text-danger">*</span></label>
                                    <input id="productname" name="vendor_code" type="text" class="form-control" value="{{$companies->vendor_code}}" placeholder="Vendor Code">
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="manufacturername">Mobile Number </label>
                                    <input id="manufacturername" name="phone" type="text" class="form-control" value="{{$companies->phone}}" placeholder="Mobile Number">
                                    @if ($errors->has('phone'))
                                        <div class="text-danger">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="productname">State <span class="text-danger">*</span></label>
                                    <input id="productname" name="state" type="text" class="form-control" value="{{$companies->state}}" placeholder="State">
                                    @if ($errors->has('state'))
                                        <div class="text-danger">{{ $errors->first('state') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="manufacturerbrand">Address 1 <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address_1" id="" cols="30" rows="4">{{$companies->address_1}}</textarea>
                                    @if ($errors->has('address_1'))
                                        <div class="text-danger">{{ $errors->first('address_1') }}</div>
                                    @endif
                                </div>

                                <div class="col-6 col-md-4">
                                    <label for="manufacturerbrand">Address 2 <span class="text-danger">*</span></label>
                                    <textarea class="form-control"name="address_2" id="" cols="30" rows="4">{{$companies->address_2}}</textarea>
                                    @if ($errors->has('address_2'))
                                        <div class="text-danger">{{ $errors->first('address_2') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-4">
                                    <label for="manufacturerbrand">Address 3</label>
                                    <textarea class="form-control" name="address_3" id="" cols="30" rows="4">{{$companies->address_3}}</textarea>
                                </div>
                                <div class="col-6 col-md-4 mt-3">
                                    <label for="is_lut">Is LUT <span class="text-danger">*</span></label>
                                    <input id="is_lut" name="is_lut" type="radio" class="form-check-input @error('is_lut') is-invalid @enderror"
                                        value="1" {{ (old('is_lut', $companies->is_lut) == '1') ? 'checked' : '' }}>
                                    @error('is_lut')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6 col-md-4 lut_no">
                                    <label for="productname">LUT No <span class="text-danger">*</span></label>
                                    <input id="productname" name="lut_no" type="text" class="form-control lut_no @error('lut_no') is-invalid @enderror" placeholder="LUT NO" value="{{$companies->lut_no}}">
                                    @error('lut_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-4 doa">
                                    <label for="productname">DOA <span class="text-danger">*</span></label>
                                    <input id="productname" name="doa" type="date" class="form-control doa @error('doa') is-invalid @enderror" placeholder="DOA" value="{{$companies->doa}}">
                                    @error('doa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">GST Number <span class="text-danger">*</span></label>
                                    <div id="gst-container">
                                        @if($gstNumbers->isNotEmpty())
                                            @foreach($gstNumbers as $key => $gst)
                                                <div class="gst-input-group" style="display: flex; margin-bottom: 5px;">
                                                    <input type="hidden" name="gid[]" value="{{$gst->id}}">
                                                    <input name="gstnumber[]"
                                                        style="margin-right: 8px;"
                                                        type="text"
                                                        class="form-control gstnumber @error('gstnumber') is-invalid @enderror"
                                                        value="{{ old('gstnumber.' . $key, $gst->gstnumber) }}"
                                                        placeholder="GST Number">
                                                    @if($key == 0)
                                                        <button type="button" class="btn btn-info add-gst">+</button>
                                                    @else
                                                      <a href="javascript:void(0);" data-id="{{$gst->id}}" class=" btn btn-danger remove-gst delete-gst">x</a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="gst-input-group" style="display: flex;">
                                                <input name="gstnumber[]"
                                                    style="margin-right: 8px;"
                                                    type="text"
                                                    class="form-control gstnumber @error('gstnumber') is-invalid @enderror"
                                                    value="{{ old('gstnumber.0') }}"
                                                    placeholder="GST Number">
                                                <button type="button" class="btn btn-info add-gst">+</button>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                @error('gstnumber')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="row mt-3">
                                <div class="col-12">
                                    <div id="invoiceCount"  class="text-danger"></div>
                                    <div data-repeater-list="group-a" id="dynamicAddRemove">
                                        <div data-repeater-item class="row mb-2" style="padding: 6px">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">

                                                        @foreach ($errors->getMessages() as $key => $messages)
                                                            @if (preg_match('/\.\d+$/', $key))
                                                                @foreach ($messages as $message)
                                                                    <p>{{ $message }}</p>
                                                                @endforeach
                                                            @endif
                                                        @endforeach

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
                                                    @foreach ($companyService as $index => $item)
                                                        <tr>
                                                            <td class="mb-3 col-lg-1" style="width: 5%;">
                                                                <input type="text" style="text-align: center;"class="form-control no" value="{{$index +1}}" readonly />
                                                                <input type="hidden" style="text-align: center;" id="sr_no" name="sr_no[]" class="form-control sr_no" value="{{$item->id}}" />
                                                            </td>
                                                            <td class="mb-3 col-lg-3" style="width: 6%;">
                                                                <input type="text" id="order_no" name="order_no[]" class="form-control code" value="{{$item->order_no}}" placeholder="Order No" />
                                                            </td>
                                                            <td class="mb-3 col-lg-3" style="width: 12%;">
                                                                <input type="text" id="code" name="service_code[]" class="form-control code" value="{{$item->service_code}}" placeholder="Service Code" />
                                                            </td>
                                                            <td class="mb-3 col-lg-3" style="width: 19%;">
                                                                <textarea type="text" id="description" name="job_description[]" class="form-control description" value="" placeholder="Job Description" >{{$item->job_description}}</textarea>
                                                            </td>
                                                            <td class="mb-3 col-lg-1">
                                                                <input type="text" id="uom" name="uom[]" class="form-control uom" value="{{$item->uom}}" placeholder="UOM" />
                                                            </td>
                                                            <td class="mb-3 col-lg-1">
                                                                <input type="text" id="price" name="price[]" class="form-control price" value="{{$item->price}}" placeholder="Price" />
                                                            </td>
                                                            <td class="mb-3 col-lg-1" style="width: 0%;">
                                                                @if($index === 0)
                                                                    <input data-repeater-create type="button" id="addService" class="btn btn-info addService mt-5 mt-lg-0" value="+" />
                                                                @else
                                                                    <a href="javascript:void(0);" data-id="{{$item->id}}" class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Update Register Company</button>
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
                $(this).find('.no').val(index + 1);
            });
        }

        $('.addService').on('click', function() {
            var numberofrow = ($('.addMultipleService tr').length - 0) + 1;
            var tr =`
                <tr>
                    <td class="mb-3 col-lg-1" style="width: 5%;">
                        <input type="text" style="text-align: center;" id="no" name="no[]" class="form-control no" value="" readonly />
                        <input type="hidden" style="text-align: center;" id="sr_no" name="sr_no[]" class="form-control sr_no" value="0" />
                    </td>
                    <td class="mb-3 col-lg-3" style="width: 6%;">
                        <input type="text" id="order_no" name="order_no[]" class="form-control code" value="" placeholder="Order No" />
                        @error('order_no.*')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </td>
                    <td class="mb-3 col-lg-3" style="width: 12%;">
                        <input type="text" id="code" name="service_code[]" class="form-control code" value="" placeholder="Service Code" />
                        @error('service_code.*')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </td>
                    <td class="mb-3 col-lg-3" style="width: 19%;">
                        <textarea type="text" id="description" name="job_description[]" class="form-control description" value="" placeholder="Job Description" ></textarea>
                        @error('job_description.*')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </td>
                    <td class="mb-3 col-lg-1">
                        <input type="text" id="uom" name="uom[]" class="form-control uom" value="" placeholder="UOM" />
                        @error('uom.*')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </td>
                    <td class="mb-3 col-lg-1">
                        <input type="text" id="price" name="price[]" class="form-control price" value="" placeholder="Price" />
                        @error('price.*')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </td>
                    <td class="mb-3 col-lg-1" style="width: 0%;"><a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a></td>
                </tr>`;
            $('.addMultipleService').append(tr);
            updateRowNumbers();
        });

        // Delete a row
        $('.addMultipleService').delegate('.remove-input-field', 'click ', function() {
            $(this).parent().parent().remove();
            updateRowNumbers();
        })

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

        $(document).ready(function() {
            $('.remove-input-field').click(function() {
                var serviceCodeId = $(this).data('id');
                var $button = $(this);

                $.ajax({
                    url: '{{ route('delete.service.code') }}',
                    type: 'POST',
                    data: {
                        id: serviceCodeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'error') {
                            alert(response.message);
                            location.reload();
                        } else {
                            if (confirm('Are you sure you want to delete this service code?')) {
                                $.ajax({
                                    url: '{{ route('delete.service.code') }}',
                                    type: 'POST',
                                    data: {
                                        id: serviceCodeId,
                                        _token: '{{ csrf_token() }}',
                                        confirm: true
                                    },
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            toastr.success('Service Code Delete successfully.');
                                            $button.closest('td').remove(); // Or appropriate removal of the element
                                            updateRowNumbers();
                                            location.reload();
                                        }
                                    }
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // For each error, display the message in the correct row
                        if (errors['service_code']) {
                            errors['service_code'].forEach(function(error, index) {
                                // Update the label for each service_code row
                                $('.service_code_error_' + (index + 1)).text(error);
                            });
                        }
                    }
                });
            });
        });

        $(document).on('click', '.delete-gst', function(e) {
            e.preventDefault();
            var gstId = $(this).data('id');
            var $this = $(this);

            if (confirm('Are you sure you want to delete this GST number?')) {
                $.ajax({
                    url: '{{ route('gst.destroy') }}',  // Ensure the route is correct
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token required for Laravel DELETE requests
                        gid: gstId // Send GST ID
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $this.closest('.gst-input-group').remove();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(response) {
                        alert('Something went wrong. Please try again.');
                    }
                });
            }
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
