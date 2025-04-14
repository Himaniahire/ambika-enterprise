@extends('admin.layouts.layout')
@section('content')

<style>
    .btnn:hover {
    color: var(--bs-btn-hover-color);
    text-decoration: none;
    background-color: none;
    border-color: none;
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
                                Register Companies List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-primary" href="{{ route('register_company.create') }}">
                                <i class="me-1" data-feather="user-plus"></i>
                                Add New Company
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    <table id="comTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>State</th>
                                <th>GST Number</th>
                                <th>PAN Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>State</th>
                                <th>GST Number</th>
                                <th>PAN Number</th>
                                <th>Status</th>
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

$(document).ready(function() {
    // Attach event listener to dynamically generated buttons
    $(document).on('click', '.toggle-status', function() {
        var button = $(this);
        var currentStatus = button.data('status');
        var newStatus = currentStatus === 1 ? 0 : 1;
        var id = button.data('id');
        var message = newStatus === 1 ? 'Do you want to set the status to Active?' : 'Do you want to set the status to Inactive?';

        if (confirm(message)) {
            $.ajax({
                url: '{{ route("toggle.status") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        // Update the button's status data attribute
                        button.data('status', response.status);

                        // Update the button's image source and class based on new status
                        var newImageSrc = response.status === 1 ? '{{ asset("admin_assets/index_icon/switch2.png") }}' : '{{ asset("admin_assets/index_icon/switch1.png") }}';
                        var newClass = response.status === 1 ? 'btn-switch-on' : 'btn-switch-off';

                        button.find('img').attr('src', newImageSrc);
                        button.removeClass('btn-switch-on btn-switch-off').addClass(newClass);

                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error('An error occurred.');
                }
            });
        }
    });

    // Initialize DataTable
    $('#comTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('register_company.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'companyname', name: 'companyname' },
            { data: 'state', name: 'state' },
            { data: 'gstnumber', name: 'gstnumber' },
            { data: 'pannumber', name: 'pannumber' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        drawCallback: function(settings) {
                    feather.replace(); // Re-initialize Feather icons
                },
        order: [[1, 'asc']] // Example: Sort by Company Name
    });
});


</script>

@endsection
