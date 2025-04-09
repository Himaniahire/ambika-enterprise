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
                                    Edit Purchase Order
                                </h1>
                            </div>
                            <div class="col-12 col-xl-auto mb-3">
                                <a class="btn btn-primary" href="{{ route('purchase_order.index') }}">
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
                                <form action="{{ route('purchase_order.update', $purchaseOrder->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <!-- Form Row -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group -->
                                        <div class="col-6 col-md-4">
                                            <label class="small mb-1" for="inputFirstName">Company Name <span class="text-danger">*</span></label>
                                            <select class="form-control" id="company_id" name="company_name">
                                                <option value="{{ $purchaseOrder->getCompany->id }}">
                                                    {{ $purchaseOrder->getCompany->companyname }}</option>
                                                @foreach ($companies as $item)
                                                    <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                                @endforeach
                                            </select>
                                            @error('company_name')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="col-6 col-md-4" id="inputContainer">
                                            <label class="small mb-1" for="inputFirstName">PO No. <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="po_no" value="{{ $purchaseOrder->po_no }}" />
                                            @error('po_no')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="small mb-1" for="inputFirstName">PO Date <span class="text-danger">*</span></label>
                                            <input class="form-control" id="inputFirstName" type="text" name="po_date" value="{{ $purchaseOrder->po_date }}" />
                                            @if ($errors->has('po_date'))
                                                <div class="text-danger">{{ $errors->first('po_date') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="small mb-1" for="inputFirstName">Unit</label>
                                            <input class="form-control" id="inputFirstName" type="text" name="com_unit" value="{{ $purchaseOrder->com_unit }}" placeholder="Company Unit" />
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="small mb-1" for="inputFirstName">Plant</label>
                                            <input class="form-control" id="inputFirstName" type="text" name="plant" value="{{ $purchaseOrder->plant }}" placeholder="Plant" />
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="small mb-1" for="inputFirstName">Department</label>
                                            <input class="form-control" id="inputFirstName" type="text" name="department" value="{{ $purchaseOrder->department }}" placeholder="Department" />
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label class="small mb-1" for="inputFirstName">Contact Name</label>
                                            <input class="form-control" id="inputFirstName" type="text" name="contact_name"
                                                value="{{ $purchaseOrder->contact_name }}" />
                                        </div>

                                        <div class="col-6 col-md-4">
                                            <label class="small mb-1" for="inputFirstName">Contact Number</label>
                                            <input class="form-control" id="inputFirstName" type="text" name="contact_num"
                                                value="{{ $purchaseOrder->contact_num }}" />
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
                                                                @php $i = 1; @endphp
                                                                @foreach ($products as  $index => $item)
                                                                    <tr id="product-row-{{$item->id}}">
                                                                        <td class="mb-3 col-lg-1" style="width: 5%;">
                                                                            <input type="text" style="text-align: center;" class="form-control" value="{{$index + 1}}" readonly />
                                                                            <input  type="hidden" style="text-align: center;" id="sr_no" name="sr_no[]" class="form-control" value="{{ $item->id }}" readonly />
                                                                        </td>
                                                                        <td class="mb-3 col-lg-3" style="width: 12%;">
                                                                            <select class="form-control service_code_id mb-3" name="service_code[]" id="service_code_id">
                                                                                <option value="{{ $item->service_code_id }}">{{ $item->getServiceCode->service_code ?? "N/A"}}</option>
                                                                                @foreach ($serviceCodes as $serviceCode)
                                                                                    <option value="{{ $serviceCode->service_code_id }}">{{ $serviceCode->service_code ?? "N/A"}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td class="mb-3 col-lg-3" style="width: 19%;">
                                                                            <textarea type="text" id="job_description" name="job_description[]" class="form-control job_description" value="" placeholder="Job Description" readonly>{{ $item->job_description }}</textarea>
                                                                        </td>
                                                                        <td class="mb-3 col-lg-1"><input type="text" id="hsn_sac_code" name="hsn_sac_code[]" class="form-control hsn_sac_code" value="{{ $item->hsn_sac_code }}" placeholder="HSN/SAC Code" /></td>
                                                                        <td class="mb-3 col-lg-1"><input type="text" id="uom" name="uom[]" class="form-control uom" value="{{ $item->uom }}" placeholder="UOM" readonly /></td>
                                                                        <td class="mb-3 col-lg-1"><input type="text" id="price" name="price[]" class="form-control price" value="{{ $item->price }}" placeholder="Price" readonly /></td>
                                                                        <td class="mb-3 col-lg-1"><input type="text" id="qty" name="qty[]" class="form-control qty" value="{{ $item->qty }}" placeholder="Qty" /></td>
                                                                        <td class="mb-3 col-lg-2" style="width: 7%;"><input type="text" id="total_amount" name="total_amount[]" class="form-control total_amount" value="{{ $item->total_amount }}" placeholder="Amount" readonly /></td>
                                                                        <td class="mb-3 col-lg-1" style="width: 0%;">
                                                                            @if($index === 0)
                                                                                <input  data-repeater-create type="button"  id="addPO" class="btn btn-info addPO mt-5 mt-lg-0" value="+" />
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
                                        <div class="col-6 col-md-3">
                                            <label class="small mb-1" for="inputFirstName">Document</label>
                                            <input class="form-control" type="file" name="document" id="">
                                        </div>
                                        <div class="col-6 col-md-12" style="padding:0px 130px;">
                                            <label class="small mb-1" for="inputFirstName"
                                                style="font-size: 19px;font-weight: bold;float: right">Total Amount: <span
                                                    style="float: right; padding: 0px 0px 0px 20px;" class="total"
                                                    id="total" type="text"
                                                    name="total">{{ $purchaseOrder->total }}</span></label>

                                            <input style="float: right" class="form-control" id="inputFirstName"
                                                type="hidden" name="total" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Update PO</button>
                                    
                                </form>
                                @if (!empty($purchaseOrder->document))
                                    <label class="m-2">Document</label>
                                    <form action="{{ url('accountant/purchase_order/deletepodocument/' . $purchaseOrder->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn text-danger">X</button>
                                    </form>
                                    
                                    <iframe src="{{ asset('po_pdf/' . $purchaseOrder->document) }}" width="50%" height="300px"></iframe>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @endsection

    @section('footer-script')
        <script>

            // function updateRowNumbers() {
            //     $('.addMultiplePO tr').each(function(index) {
            //         $(this).find('.sr_no').val(index + 1);
            //     });
            // }
            // $('.addPO').on('click', function() {
            //     var numberofrow = ($('.addMultiplePO tr').length - 0) + 1;
            //     var tr =
            //         '<tr><td class="mb-3 col-lg-1" style="width: 5%;"><input type="text" id="sr_no" name="sr_no[]" class="form-control sr_no" value="' + numberofrow + '" readonly /></td>' +
            //         '<td class="mb-3 col-lg-3" style="width: 12%;"><select class="form-control service_code_id mb-3" name="service_code[]" id="service_code_id"><option value="">Select Product</option></select></td>' +
            //         '<td class="mb-3 col-lg-3" style="width: 19%;"><textarea type="text" id="job_description" name="job_description[]" class="form-control job_description" value="" placeholder="Job Description" ></textarea></td>' +
            //         '<td class="mb-3 col-lg-1"><input type="text" id="hsn_sac_code" name="hsn_sac_code[]" class="form-control hsn_sac_code" value="" placeholder="HSN/SAC Code" /></td>' +
            //         '<td class="mb-3 col-lg-1"><input type="text" id="uom" name="uom[]" class="form-control uom" value="" placeholder="UOM" /></td>' +
            //         '<td class="mb-3 col-lg-1"><input type="text" id="price" name="price[]" class="form-control price" value="" placeholder="Price" /></td>' +
            //         '<td class="mb-3 col-lg-1"><input type="text" id="qty" name="qty[]" class="form-control qty" value="" placeholder="Qty" /></td>' +
            //         '<td class="mb-3 col-lg-2" style="width: 7%;"><input type="text" id="total_amount" name="total_amount[]" class="form-control total_amount" value="" placeholder="Amount" readonly/></td>' +
            //         '<td class="mb-3 col-lg-1" style="width: 0%;"><a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a></td></tr>';
            //     $('.addMultiplePO').append(tr);
            //     updateRowNumbers();
            // });
            // // Delete a row
            // $('.addMultiplePO').delegate('.remove-input-field', 'click ', function() {
            //     $(this).parent().parent().remove();
            //     updateRowNumbers();
            // })

            // function TotalAmount() {
            //     // I will make all the Logic here
            //     var total = 0;
            //     $('.total_amount').each(function(i, e) {
            //         var amount = parseFloat($(this).val()) || 0;
            //         total += amount.toFixed(2);
            //     });
            //     $('.total').html(total);
            // }

            // $('.addMultiplePO').on('keyup', '#qty, #price', function() {
            //     var tr = $(this).closest('tr');
            //     var qty = parseFloat(tr.find('#qty').val()) || 0;
            //     var price = parseFloat(tr.find('#price').val()) || 0;
            //     var total_amount = qty * price;
            //     total_amount = total_amount.toFixed(2);
            //     tr.find('#total_amount').val(total_amount);
            //     TotalAmount();
            // });

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

                // $('#company_id').change(function() {
                //     var companyId = $(this).val();
                //     if (companyId) {
                //         $.ajax({
                //             url:  "{{ route('get.service.codes', ':id') }}".replace(':id', companyId),
                //             type: 'GET',
                //             dataType: 'json',
                //             success: function(data) {
                //                 $('.service_code_id').empty();
                //                 $('.service_code_id').append('<option value="">Select Product</option>');
                //                 $.each(data, function(key, value) {
                //                     $('.service_code_id').append('<option value="' + key + '">' + value + '</option>');
                //                 });
                //             }
                //         });
                //     } else {
                //         $('.service_code_id').empty();
                //         $('.service_code_id').append('<option value="">Select Product</option>');
                //     }
                // });
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
                    var tr = `
                        <tr>
                            <td class="mb-3 col-lg-1" style="width: 5%;">
                                <input type="text" id="sr_no" name="sr_no[]" class="form-control sr_no" value="` + numberofrow + `" readonly />
                            </td>
                            <td class="mb-3 col-lg-3" style="width: 12%;">
                                <select class="form-control service_code_id mb-3" name="service_code[]" id="service_code_id">
                                    <option value="">Select Service Code</option>
                                </select>
                            </td>
                            <td class="mb-3 col-lg-3" style="width: 19%;">
                                <textarea type="text" id="job_description" name="job_description[]" class="form-control job_description" placeholder="Job Description" readonly></textarea>
                            </td>
                            <td class="mb-3 col-lg-1">
                                <input type="text" id="hsn_sac_code" name="hsn_sac_code[]" class="form-control hsn_sac_code" placeholder="HSN/SAC Code" />
                            </td>
                            <td class="mb-3 col-lg-1">
                                <input type="text" id="uom" name="uom[]" class="form-control uom" placeholder="UOM" readonly />
                            </td>
                            <td class="mb-3 col-lg-1">
                                <input type="text" id="price" name="price[]" class="form-control price" placeholder="Price" readonly />
                            </td>
                            <td class="mb-3 col-lg-1">
                                <input type="text" id="qty" name="qty[]" class="form-control qty" placeholder="Qty" />
                            </td>
                            <td class="mb-3 col-lg-2" style="width: 7%;">
                                <input type="text" id="total_amount" name="total_amount[]" class="form-control total_amount" placeholder="Amount" readonly />
                            </td>
                            <td class="mb-3 col-lg-1" style="width: 0%;">
                                <a class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a>
                            </td>
                        </tr>`;
                    $('.addMultiplePO').append(tr);
                
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

            $(document).ready(function() {
                $('.remove-input-field').click(function() {
                    var productId = $(this).data('id');
                    var row = $('#product-row-' + productId);

                    if (confirm('Are you sure you want to delete this product?')) {
                        $.ajax({
                            url:  "{{ route('purchase_order.product_destroy', ':id') }}".replace(':id', productId),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                if (response.success) {
                                    row.remove();
                                } else {
                                    alert('Failed to delete the product.');
                                }
                            },
                            error: function(xhr) {
                                alert('Error: ' + xhr.status + ' ' + xhr.statusText);
                            }
                        });
                    }
                });
            });
        </script>
    @endsection
