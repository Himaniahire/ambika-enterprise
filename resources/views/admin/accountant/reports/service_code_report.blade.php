@extends('admin.layouts.layout')
@section('content')

<style>
    @media (min-width: 1500px) {
    .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 1661px;
    }
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
                                Service Code Report
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">

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
                        <div class="card-header">Service Code Report</div>
                        <div class="card-body">
                            <form action="" method="" id="report-form">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Company Name</label>
                                        <select class="form-control" id="company_id" name="company_id" required>
                                            <option value="">Select Company Name</option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">PO NO</label>
                                        <select class="form-control poSelect" style="display:none;" id="po_id" name="po_id">
                                            <option value="">Select Purchase Order</option>
                                        </select>
                                        <div id="noPoMessage" style="display:none;color:red;">There is no PO available.</div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <label class="small mb-1" for="inputFirstName">Service Code</label>
                                        <select class="form-control service_code_id" style="height: 36px;" name="service_code_id" id="service_code_id">
                                            <option value="">Select Service Code</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <main>
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Account details card -->
                    <div class="card mb-4">
                        <div class="card-header">Service Code Report</div>
                        <div class="card-body" style="padding: 17px 6px 17px 6px;">
                            <table id="reportPOTable"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('footer-script')
<!-- JavaScript -->
<script src="https://unpkg.com/feather-icons"></script>
<script>

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

$(document).ready(function() {
    // Fetch and populate service codes when the company_id changes
    $('#company_id').change(function() {
        var companyId = $(this).val();
        if (companyId) {
            $.ajax({
                url: "{{ route('get.services', ':id') }}".replace(':id', companyId),
                type: 'GET',
                success: function(data) {
                    $('.service_code_id').empty().append('<option value="">Select Company Service Code </option>');
                    $.each(data, function(index, service) {
                        $('.service_code_id').append('<option value="' + service.id + '">' + service.service_code + '</option>');
                    });
                }
            });
        }
    });

    // Fetch and populate service codes when the poSelect changes
    $('.poSelect').change(function() {
        var poId = $(this).val();
        if (poId) {
            $.ajax({
                url: "{{ route('get-service', ':id') }}".replace(':id', poId),
                type: 'GET',
                success: function(data) {
                    $('.service_code_id').empty().append('<option value="">Select PO Service Code</option>');
                    $.each(data, function(index, service) {
                        $('.service_code_id').append('<option value="' + service.id + '">' + service.service_code + '</option>');
                    });
                }
            });
        }
    });
});

$(document).ready(function() {
    var dataTable;
    $('#report-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ route("fetch.data.service.code") }}',
            type: 'GET',
            data: formData,
            success: function(response) {
                // Destroy the existing datatable if it exists
                if (dataTable) {
                    dataTable.destroy();
                }

                // Initialize the new datatable with updated data
                dataTable = new DataTable('#reportPOTable', {
                    data: response.data, // Use 'data' property from JSON response to populate the table
                    columns: [
                        { data: 'company_name', title: 'Company Name', defaultContent: 'N/A' },
                        { data: 'service_code', title: 'Service Code', defaultContent: 'N/A' },
                        { data: 'po_no', title: 'PO no', defaultContent: 'N/A' },
                        { data: 'sum_no', title: 'summary no', defaultContent: 'N/A' },
                        { data: 'invoice_no', title: 'Invoice No', defaultContent: 'N/A' },
                        { data: 'performa_no', title: 'Performa No', defaultContent: 'N/A' },
                        { data: 'total_qty', title: 'Total QTY', defaultContent: 'N/A' },
                    ]
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

    });
});


</script>


@endsection
