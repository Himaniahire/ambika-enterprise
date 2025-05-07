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
                            Edit Summary
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-primary" href="{{route('summary.index')}}">
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
                        <form id="summaryUpdateForm" action="{{ route('summary.update', $summaries->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <input class="form-control" id="inputFirstName" type="hidden" name="order_no"  value="" />
                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Company Name <span class="text-danger">*</span></label>
                                    <select class="form-control" id="company_id" name="company_name">
                                        <option value="{{$summaries->getCompany->id}}">{{$summaries->getCompany->companyname}}</option>
                                        @foreach ($companies as $item)
                                            <option value="{{$item->id}}">{{$item->companyname}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('company_name'))
                                        <div class="text-danger">{{ $errors->first('company_name') }}</div>
                                    @endif
                                </div>

                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">GST Number</label>
                                    @if (isset($summaries->gst_id) && $summaries->getGST)

                                        <select class="form-control gstSelect" id="gstSelect" name="gst_id">
                                            <option value="{{ $summaries->getGST->id ?? "NO GST"}}">{{ $summaries->getGST->gstnumber ?? "NO GST" }}</option>
                                            @foreach($gstNumbers as $gstNumber)
                                                <option value="{{ $gstNumber->id }}">{{ $gstNumber->gstnumber }}</option>
                                            @endforeach
                                        </select>

                                    @else

                                        <select class="form-control gstSelect" style="display:none;" id="gstSelect" name="gst_id">
                                            <option value="">Select GST Number</option>
                                        </select>

                                    @endif


                                    <div id="noPoMessage" style="display:none;color:red;">There is no GST available.</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">PO Number</label>
                                    @if (isset($summaries->po_no_id) && $summaries->getPO)

                                        <select class="form-control poSelect" id="poSelect" name="po_no_id">
                                            <option value="{{ $summaries->getPO->id ?? "NO PO"}}">{{ $summaries->getPO->po_no ?? "NO PO" }}</option>
                                            @foreach($poNumbers as $poNumber)
                                                <option value="{{ $poNumber->id }}">{{ $poNumber->po_no }}</option>
                                            @endforeach
                                        </select>

                                    @else

                                        <select class="form-control poSelect" style="display:none;" id="poSelect" name="po_no_id">
                                            <option value="">Select Purchase Order</option>
                                        </select>

                                    @endif


                                    <div id="noPoMessage" style="display:none;color:red;">There is no PO available.</div>
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Summary Duration <span class="text-danger">*</span></label>
                                    <input type="text" name="summary_duration" class="form-control" value="{{$summaries->summ_date}}" placeholder="" />
                                    @if ($errors->has('summary_duration'))
                                        <div class="text-danger">{{ $errors->first('summary_duration') }}</div>
                                    @endif
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Summary No <span class="text-danger">*</span></label>
                                    <input type="text" id="sum_no" name="sum_no" class="form-control" value="{{$summaries->sum_no}}"
                                        @if(auth()->user()->role_id == 1)
                                            @removeReadonly
                                        @else
                                            readonly
                                        @endif placeholder="Summary No" />
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Company Unit</label>
                                    <input type="text" name="com_unit" class="form-control" value="{{$summaries->com_unit}}"
                                        placeholder="Company Unit" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Plant</label>
                                    <input type="text"  name="plant" class="form-control" value="{{$summaries->plant}}" placeholder="Plant" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Department</label>
                                    <input type="text"  name="department" class="form-control" value="{{$summaries->department}}" placeholder="Department" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Category Of Services <span class="text-danger">*</span></label>
                                    <select class="form-control" id="category_of_service_id" name="category_of_service">
                                        @if ($summaries->category_of_service_id === null)
                                            <option value="">Select</option>
                                        @else
                                            <option value="{{$summaries->getCategoryOfService->id}}">{{$summaries->getCategoryOfService->category_of_service}}</option>
                                        @endif
                                        @foreach ($categoryOfService as $item)
                                             <option value="{{ $item->id }}">{{ $item->category_of_service }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_of_service'))
                                        <div class="text-danger">{{ $errors->first('category_of_service') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-3" id="inputContainer">
                                    <label class="small mb-1" for="inputFirstName">Work Period <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="work_period" id="work_period"  value="{{$summaries->work_period}}"/>
                                    @if ($errors->has('work_period'))
                                        <div class="text-danger">{{ $errors->first('work_period') }}</div>
                                    @endif
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">JMR No</label>
                                    <input class="form-control" id="jmr_no" type="text" name="jmr_no" value="{{$summaries->jmr_no}}" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Capex No</label>
                                    <input class="form-control" id="capex_no" type="text" name="capex_no" value="{{$summaries->capex_no}}" />
                                </div>
                                <div class="col-6 col-md-3" id="inputContainer">
                                    <label class="small mb-1" for="inputFirstName">Work/Contract Order No</label>
                                    <input class="form-control" type="text" name="work_contract_order_no" id="work_contract_order_no" value="{{$summaries->work_contract_order_no}}"/>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div data-repeater-list="group-a" id="dynamicAddRemove">
                                            <div data-repeater-item class="row mb-2" style="background-color: #f6f9fd; padding: 6px">
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

                                                                @error('performa_date')
                                                                    <li class="text-danger">{{ $message }}</li>
                                                                @enderror
                                                                @error('tax')
                                                                    <li class="text-danger">{{ $message }}</li>
                                                                @enderror
                                                                @error('invoice_date')
                                                                    <li class="text-danger">{{ $message }}</li>
                                                                @enderror
                                                            </ul>
                                                        </div>
                                                    @endif

                                                <table class="table">
                                                    <span id="multi-error-message" class="multi-error"></span>
                                                    <thead>
                                                        <tr>
                                                            <th>Date <span class="text-danger">*</span></th>
                                                            <th>Pg No.</th>
                                                            <th>Sr No.</th>
                                                            <th>Service Code <span class="text-danger">*</span></th>
                                                            <th>Description</th>
                                                            <th>Length <span class="text-danger">*</span></th>
                                                            <th>Width <span class="text-danger">*</span></th>
                                                            <th>Height <span class="text-danger">*</span></th>
                                                            <th>Nos <span class="text-danger">*</span></th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="addMultipleSummary">
                                                        @php $i = 1; @endphp


                                                        @foreach ($products as $index => $product)
                                                            <tr id="product-row-{{$product->id}}">
                                                                <td class="mb-3 col-lg-2" style="width: 12%;">
                                                                    <input type="text" id="sum_date" name="sum_date[]" class="form-control sum_date" value="{{$product->sum_date}}" placeholder="DD-MM-YYYY" />
                                                                </td>
                                                                <td class="mb-3 col-lg-1" style="width: 5%;">
                                                                    <input type="text" style="text-align: center;" id="pg_no" name="pg_no[]" class="form-control pg_no" value="{{$product->pg_no}}" placeholder="Page No." />
                                                                </td>
                                                                <td class="mb-3 col-lg-1" style="width: 5%;">
                                                                    <input type="text" style="text-align: center;" class="form-control" value="{{$index + 1}}" readonly />
                                                                    <input type="hidden" id="sr_no" name="sr_no[]" class="form-control" value="{{ $product->id }}" readonly />
                                                                </td>
                                                                <td class="mb-3 col-lg-3" style="width: 12%;">
                                                                    <select class="form-control service_code_id" style="height: 36px;" name="service_code_id[]" id="service_code_id">
                                                                        <option value="{{ $product->companyServiceCode->id ?? 'N/A' }}"
                                                                                data-service-code="{{ $product->companyServiceCode->service_code ?? 'N/A' }}">
                                                                            {{ $product->companyServiceCode->service_code ?? $product->service_code ?? 'N/A' }}
                                                                        </option>
                                                                        @if ($product->po_id == null)
                                                                            @foreach($companyServiceCodes as $companyServiceCode)
                                                                                <option value="{{ $companyServiceCode->id ?? 'N/A' }}"
                                                                                        data-service-code="{{ $companyServiceCode->service_code ?? 'N/A' }}">
                                                                                    {{ $companyServiceCode->service_code ?? 'N/A' }}
                                                                                </option>
                                                                            @endforeach
                                                                        @else
                                                                            @foreach($poServiceCodes as $poServiceCode)
                                                                                <option value="{{ $poServiceCode->id ?? 'N/A' }}"
                                                                                        data-service-code="{{ $poServiceCode->service_code ?? 'N/A' }}">
                                                                                    {{ $poServiceCode->service_code ?? 'N/A' }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>

                                                                    <input type="hidden" name="service_code[]" class="service_code_input" value="{{ $product->service_code }}">
                                                                </td>

                                                                <td class="mb-3 col-lg-3">
                                                                    <input type="text" id="job_description" name="job_description[]" class="form-control job_description" value="{{$product->job_description}}" placeholder="Description" readonly />
                                                                    <input type="hidden" name="uom[]" class="form-control uom" value="{{$product->uom}}" readonly/>
                                                                </td>
                                                                <td class="mb-3 col-lg-1">
                                                                    <input type="text" id="length" name="length[]" class="form-control length" value="{{$product->length}}" placeholder="Length" />
                                                                </td>
                                                                <td class="mb-3 col-lg-1">
                                                                    <input type="text" id="width" name="width[]" class="form-control width" value="{{$product->width}}" placeholder="Width" />
                                                                </td>
                                                                <td class="mb-3 col-lg-1">
                                                                    <input type="text" id="height" name="height[]" class="form-control height" value="{{$product->height}}" placeholder="Height" />
                                                                </td>
                                                                <td class="mb-3 col-lg-1">
                                                                    <input type="text" id="nos" name="nos[]" class="form-control nos" value="{{$product->nos}}" placeholder="Nos" />
                                                                </td>
                                                                <td class="mb-3 col-lg-2">
                                                                    <input type="text" id="total_qty" name="total_qty[]" class="form-control total_qty" value="{{$product->total_qty}}" placeholder="Amount" readonly />
                                                                </td>
                                                                <td class="mb-3 col-lg-1">
                                                                    @if($index === 0)
                                                                        <input data-repeater-create type="button" id="addSummary" class="btn btn-info addSummary mt-5 mt-lg-0" value="+" />
                                                                    @else
                                                                        <a href="javascript:void(0);" data-id="{{$product->id}}" class="form-control btn btn-danger mt-5 mt-lg-0 remove-input-field">x</a>
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
                                <div class="col-6 col-md-3">
                                    <label class="small mb-1" for="inputFirstName">Amount</label>
                                    <h5 class="total" id="total" type="text" name="total">{{$summaries->total}}</h5>
                                    <input class="form-control total" id="inputFirstName" type="hidden" name="total"  />
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Update Summary</button>
                        </form>
                            <button class="btn btn-primary" style="margin: -80px 0px 0px 163px;" data-bs-toggle="modal" data-bs-target="#exampleModalCenterPerforma">Generate Performa</button>

                            <div class="modal fade" id="exampleModalCenterPerforma" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Generate Performa Details</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('performa.update',$summaries->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Form Row -->
                                                <div class="row gx-3 mb-3">
                                                    <!-- Form Group -->
                                                    <div class="col-6 col-md-6">
                                                        <input type="hidden" name="company_id" value="{{$summaries->company_id}}">
                                                        <label class="small mb-1" for="inputFirstName">Performa Date <span class="text-danger">*</span></label>
                                                        @if ($summaries->performa_date)
                                                            <input class="form-control error-performa-date-message" id="performa_date" type="date" name="performa_date" value="{{$summaries->performa_date}}" />
                                                        @else
                                                            <input class="form-control error-performa-date-message" id="performa_date" type="date" name="performa_date" value="" placeholder="DD-MM-YYYY"/>
                                                        @endif
                                                        <span id="error-performa-date-message" class="error"></span>
                                                    </div>
                                                    <div class="col-6 col-md-6" id="inputContainer">
                                                        <label class="small mb-1" for="inputFirstName">GST Type</label>
                                                        @if ($summaries->gst_type)
                                                            <select class="form-control" id="gst_type" name="gst_type">
                                                                <option value="{{$summaries->gst_type}}">{{$summaries->gst_type}}</option>
                                                                <option value="CGST/SGST">CGST/SGST</option>
                                                                <option value="IGST">IGST</option>
                                                            </select>
                                                        @else
                                                            <select class="form-control" id="gst_type" name="gst_type">
                                                                <option value="">Select GST Type</option>
                                                                <option value="CGST/SGST">CGST/SGST</option>
                                                                <option value="IGST">IGST</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                    <div class="col-6 col-md-6" id="inputContainer">
                                                        <label class="small mb-1" for="inputFirstName">Tax</label>
                                                        @if ($summaries->tax)
                                                            <select class="form-control" id="tax" name="tax">
                                                                <option value="{{$summaries->tax}}">18%</option>
                                                                <option value="18">18%</option>
                                                                <option value="">0%</option>
                                                            </select>
                                                        @else
                                                            <select class="form-control" id="tax" name="tax">
                                                                <option value="">Select Tax</option>
                                                                <option value="18">18%</option>
                                                                <option value="">0%</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="inputFirstName">Performa No</label>
                                                        @if ($summaries->performa_no)
                                                            <input class="form-control" id="performa_no" type="text" name="performa_no" value="{{$summaries->performa_no}}"                                                             @if(auth()->user()->role_id == 1)
                                                            @removeReadonly
                                                        @else
                                                            readonly
                                                        @endif />
                                                        @else
                                                            <input class="form-control" id="performa_no" type="hidden" name="performa_no" value=""                                                             @if(auth()->user()->role_id == 1)
                                                            @removeReadonly
                                                        @else
                                                            readonly
                                                        @endif />
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($summaries->performa_no == NULL)
                                                   <button class="btn btn-primary" type="submit">Generate Performa</button>
                                                @else
                                                    <button class="btn btn-primary" type="submit">Update Performa</button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary" style="margin: -80px 0px 0px 10px;" data-bs-toggle="modal" data-bs-target="#exampleModalCenterInvoice">Generate Invoice</button>

                            <div class="modal fade" id="exampleModalCenterInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Generate Invoice Details</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('invoice.update',$summaries->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Form Row -->
                                                <div class="row gx-3 mb-3">
                                                    <!-- Form Group -->
                                                    <div class="col-6 col-md-6">
                                                        <input type="hidden" name="company_id" value="{{$summaries->company_id}}">
                                                        <label class="small mb-1" for="inputFirstName">Invoice Date <span class="text-danger">*</span></label>
                                                        @if ($summaries->invoice_date)
                                                            <input class="form-control" id="invoice_date" type="date" name="invoice_date" value="{{$summaries->invoice_date}}" />
                                                        @else
                                                            <input class="form-control" id="invoice_date" type="date" name="invoice_date" value="" placeholder="DD-MM-YYYY" />
                                                        @endif
                                                        <span id="error-invoice-date-message" class="error"></span>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <label class="small mb-1" for="inputFirstName">Invoice No</label>
                                                        @if ($summaries->invoice_no == NULL)
                                                            <input class="form-control" id="invoice_no" type="hidden" name="invoice_no" value="" />
                                                        @else
                                                            <input class="form-control" id="invoice_no" type="text" name="invoice_no" value="{{$summaries->invoice_no}}"
                                                            @if(auth()->user()->role_id == 1)
                                                                @removeReadonly
                                                            @else
                                                                readonly
                                                            @endif  />
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($summaries->invoice_no == NULL)
                                                   <button class="btn btn-primary" type="submit">Generate Invoice</button>
                                                @else
                                                    <button class="btn btn-primary" type="submit">Update Invoice</button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!empty($summaries->document))
                                <label class="m-2">Document</label>
                                <form action="{{ url('accountant/summary/deletesummarydocument/'.$summaries->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn text-danger">X</button>
                                </form>
                                <iframe src="{{ asset('summary_pdf/' . $summaries->document) }}" width="50%" height="300px"></iframe>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection



@section('footer-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

    
        
        $(document).ready(function() {
            $('.remove-input-field').click(function() {
                var docId = $(this).data('id');
                var row = $('#product-row-' + docId);
    
                if (confirm('Are you sure you want to delete this Product?')) {
                    $.ajax({
                        url:  "{{ route('summary.product_destroy', ':id') }}".replace(':id', docId),
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

        // $(document).ready(function() {
        //     $('#dateInput').on('input', function() {
        //         var dateInput = $(this).val();
        //         var datePattern = /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/;

        //         if (datePattern.test(dateInput)) {
        //             $('#error-message').text('');
        //         } else {
        //             $('#error-message').text('Invalid date format. Please use DD-MM-YYYY.');
        //         }
        //     });
        // });

        // $(document).ready(function() {
        //     $('#performa_date').on('input', function() {
        //         var dateInput = $(this).val();
        //         var datePattern = /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/;

        //         if (datePattern.test(dateInput)) {
        //             $('#error-performa-date-message').text('');
        //         } else {
        //             $('#error-performa-date-message').text('Invalid date format. Please use DD-MM-YYYY.');
        //         }
        //     });
        // });

        // $(document).ready(function() {
        //     $('#invoice_date').on('input', function() {
        //         var dateInput = $(this).val();
        //         var datePattern = /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/;

        //         if (datePattern.test(dateInput)) {
        //             $('#error-invoice-date-message').text('');
        //         } else {
        //             $('#error-invoice-date-message').text('Invalid date format. Please use DD-MM-YYYY.');
        //         }
        //     });
        // });

        $(document).ready(function() {
            $('.sum_date').on('input', function() {
                var dateInput = $(this).val();
                var datePattern = /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/;

                if (datePattern.test(dateInput)) {
                    $('.multi-error').text('');
                } else {
                    $('.multi-error').text('Invalid. Please use DD-MM-YYYY.');
                }
            });
        });

        $(document).ready(function() {
            // Handle company selection
            // $('#company_id').change(function() {
            //     var companyId = $(this).val();
            //     var currentYear = new Date().getFullYear();
            //     var nextYear = currentYear + 1;
            //     var lastTwoDigitsCurrentYear = String(currentYear).slice(-2);
            //     var lastTwoDigitsNextYear = String(nextYear).slice(-2);
            //     // Send AJAX request to fetch invoice number name
            //     $.ajax({
            //         url: "{{ route('get-summary-number') }}",
            //         method: 'GET',
            //         data: { company_id: companyId },
            //         success: function(response) {
            //             // Populate invoice number name input with fetched data
            //             $('#sum_no').val(lastTwoDigitsCurrentYear + '-' + lastTwoDigitsNextYear + '/' + response.inv_no_name + '/' + 'SUM');
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(error);
            //         }
            //     });
            // });

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
                            $('#noPoMessage').show();
                        }
                    }
                });
            });
        });

        // $(document).ready(function() {
        //     // Fetch and populate service codes when the company_id changes
        //     $('#company_id').change(function() {
        //         var companyId = $(this).val();
        //         if (companyId) {
        //             $.ajax({
        //                 url: "{{ route('get.services', ':id') }}".replace(':id', companyId),
        //                 type: 'GET',
        //                 success: function(data) {
        //                     $('.service_code_id').empty().append('<option value="">Select Service</option>');
        //                     $.each(data, function(index, service) {
        //                         $('.service_code_id').append('<option value="' + service.id + '">' + service.service_code + '</option>');
        //                     });
        //                 }
        //             });
        //         }
        //     });

        //     // Fetch and populate service codes when the poSelect changes
        //     $('.poSelect').change(function() {
        //         var poId = $(this).val();
        //         if (poId) {
        //             $.ajax({
        //                 url: "{{ route('get-service', ':id') }}".replace(':id', poId),
        //                 type: 'GET',
        //                 success: function(data) {
        //                     $('.service_code_id').empty().append('<option value="">Select Service</option>');
        //                     $.each(data, function(index, service) {
        //                         $('.service_code_id').append('<option value="' + service.id + '">' + service.service_code + '</option>');
        //                     });
        //                 }
        //             });
        //         }
        //     });
        // });


        $(document).ready(function() {

            function TotalAmount() {
                var total = 0;
                $('.total_qty').each(function(i, e) {
                    var amount = parseFloat($(this).val()) || 0;
                    total += amount;
                });
                $('.total').html(total.toFixed(2));
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
                            $(selectElement).append('<option value="' + service.id + '" data-service-code="' + service.service_code + '">' + service.service_code + '</option>');
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
                            $(selectElement).append('<option value="' + service.id + '" data-service-code="' + service.service_code + '">' + service.service_code + '</option>');
                        });
                    }
                });
            }

            $(document).on('change', '.service_code_id', function() {
                var selectedOption = $(this).find('option:selected');
                var serviceCode = selectedOption.data('service-code');

                $(this).closest('td').find('.service_code_input').val(serviceCode);
            });


            // Add a new row when the addSummary button is clicked
            $(document).on('click', '.addSummary', function() {
                var numberofrow = $('.addMultipleSummary tr').length + 1;
                var tr = `
                    <tr>
                        <td class="mb-3 col-lg-2" style="width: 8%;"><input type="text" name="sum_date[]" class="form-control sum_date" placeholder="Date" /><span id="multi-error-message" class="multi-error"></span></td>
                        <td class="mb-3 col-lg-1" style="width: 6%;"><input type="text" style="text-align: center;" name="pg_no[]" class="form-control pg_no" placeholder="Pg No." /></td>
                        <td class="mb-3 col-lg-1" style="width: 5%;"><input type="text" style="text-align: center;" name="sr_no[]" class="form-control sr_no" value="` + numberofrow + `" readonly /></td>
                        <td class="mb-3 col-lg-3" style="width: 12%;"><select class="form-control service_code_id" style="height: 36px;" name="service_code_id[]"><option value="">Select Service Code</option></select><input type="hidden" name="service_code[]" class="service_code_input"></td>
                        <td class="mb-3 col-lg-3"><input type="text" name="job_description[]" class="form-control job_description" placeholder="Job Description" readonly /><input type="hidden" name="uom[]" class="form-control uom" value="{{$product->uom}}" readonly/></td>
                        <td class="mb-3 col-lg-1"><input type="text" name="length[]" class="form-control length" placeholder="Length" /></td>
                        <td class="mb-3 col-lg-1"><input type="text" name="width[]" class="form-control width" placeholder="Width" /></td>
                        <td class="mb-3 col-lg-1"><input type="text" name="height[]" class="form-control height" placeholder="Height" /></td>
                        <td class="mb-3 col-lg-1"><input type="text" name="nos[]" class="form-control nos" placeholder="Nos" /></td>
                        <td class="mb-3 col-lg-2"><input type="text" name="total_qty[]" class="form-control total_qty" placeholder="Quantity" readonly /></td>
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
                tr.find('.total_qty').val(total_amount.toFixed(2));
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
            $('#summaryUpdateForm').on('submit', function(event) {
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
