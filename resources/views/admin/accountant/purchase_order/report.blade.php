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
                                Purchase Order Report
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
                        <div class="card-header">Purchase Order Report</div>
                        <div class="card-body">
                            <form action="" method="" id="po-form">
                                @csrf
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group -->
                                    <div class="col-6 col-md-12">
                                        <label class="small mb-1" for="inputFirstName">Company Name</label>
                                        <select class="form-control" id="company_id" name="company_id">
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}">{{ $item->companyname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label class="small mb-1" for="inputFirstName">Start Date</label>
                                        <input class="form-control" id="start_date" type="date" name="start_date"
                                            value="" />
                                    </div>
                                    <div class="col-6 col-md-6" id="inputContainer">
                                        <label class="small mb-1" for="inputFirstName">End Date</label>
                                        <input class="form-control" type="date" name="end_date" id="end_date"
                                            value="" />
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
                        <div class="card-header">Purchase Order Report</div>
                        <div class="card-body">
                            <table id="po-list"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('footer-script')
<!-- JavaScript -->

<script>

    $(document).ready(function() {
        $('#po-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("get-pos") }}',
                data: formData,
                success: function(response) {
                    // Initialize DataTable with the response data
                    new DataTable('#po-list', {
                        data: response,
                        columns: [
                            { data: 'po_no', title: 'PO NO' },
                            { data: 'po_date', title: 'PO Date' }
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'Copy',
                                title: 'Ambika Enterprise',
                            },
                            {
                                extend: 'csv',
                                text: 'CSV',
                                title: 'Ambika Enterprise',
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                title: 'Ambika Enterprise',
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                title: 'Ambika Enterprise',
                            },
                            {
                                extend: 'print',
                                text: 'Print',
                                title: 'Ambika Enterprise',
                            }
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
