@extends('admin.layouts.layout')
@section('content')

<style>

    table.dataTable > thead > tr > th{
        border-bottom: 1px solid rgb(0 0 0);
    }

    table.dataTable > tfoot > tr > th{
        border-top: 0;
    }

    .dataTables_wrapper .dataTables_filter {
        padding-bottom: 20px;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding-top: 0.70em;
    }

    table.dataTable tbody td {
        padding: 8px 10px;
        border-bottom: solid 1px black;
    }
    .dataTables_processing {
        display: none !important;
    }

</style>

    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Invoices Compalte List
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    <table id="invComTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('footer-script')

<script>
    // Assuming you're using jQuery for AJAX


    $(document).ready(function() {
    //Model fetch data
    $('.btn-soft-primary').on('click', function(e) {
        e.preventDefault();

        // Fetch invoice ID from data attribute
        let invoiceId = $(this).data('complete-invoice-id');

        // Perform AJAX request to fetch invoice details
        $.ajax({
            url: "{{ route('invoice.complete_details', ['invoiceId']) }}".replace('invoiceId', invoiceId),
            type: 'GET',
            success: function(data) {
                // Populate the modal with fetched data
                $('#exampleModalCenter input[name="tds"]').val(data.tds);
                $('#exampleModalCenter input[name="retention"]').val(data.retention);
                $('#exampleModalCenter input[name="payment_receive_date"]').val(data.payment_receive_date);
                $('#exampleModalCenter input[name="payment"]').val(data.payment);
                $('#exampleModalCenter input[name="penalty"]').val(data.penalty);
                $('#exampleModalCenter input[name="id"]').val(data.id);

                // Open the modal after data is populated
                $('#exampleModalCenter').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Failed to fetch Complete invoice details. Please try again.');
            }
        });
    });

    // Update Modal on form submission
    $(document).on('submit', '[id^="completeInvoiceForm"]', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: '{{ route('invoice.update-complete-invoice') }}',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastr.success('Complete Invoice updated successfully');
                $('.modal').modal('hide');
                // Optionally, update the UI with the new data
            },
            error: function(xhr, status, error) {
                alert('Failed to update Complete Invoice. Please try again.');
            }
        });
    });



});


    $(document).ready(function() {
    $('#invComTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('invoice.complete') }}", // Replace with your route
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'company_name', name: 'getSumarry.getCompany.companyname' },
            { data: 'invoice_no', name: 'getSumarry.invoice_no' },
            { data: 'invoice_date', name: 'getSumarry.invoice_date' },
            { data: 'total', name: 'getSumarry.price_total' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        drawCallback: function(settings) {
                feather.replace(); // Re-initialize Feather icons
            },
    });
});



</script>



@endsection
