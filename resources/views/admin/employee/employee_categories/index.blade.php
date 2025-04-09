@extends('admin.layouts.layout')
@section('content')
<style>
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
                            Employee Category List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                            <i class="me-1" data-feather="plus"></i>
                            Add New Employee Category
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <table id="empCatTable">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Employee category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Employee category</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Create group modal-->
    <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">Create New Category</h5>
                </div>
                <div class="modal-body">
                    <form id="createCategoryForm">
                        @csrf
                        <div class="mb-0">
                            <label class="mb-1 small text-muted" for="formGroupName">Category Name <span class="text-danger">*</span></label>
                            <input class="form-control" id="formGroupName" name="emp_category" type="text" placeholder="Enter Category..." required />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="createCategoryBtn" type="submit">Create New Category</button>
                </div>

            </div>
        </div>
    </div>


    <!-- Edit group modal-->
    <div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-labelledby="editGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGroupModalLabel">Edit Category</h5>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="mb-1 small text-muted" for="editFormGroupName">Category Name <span class="text-danger">*</span></label>
                            <input class="form-control" id="editFormGroupName" name="emp_category" type="text" placeholder="Enter Category..." required />
                            <input type="hidden" id="editCategoryId" name="id">
                        </div>
                        <button class="btn btn-primary" id="updateCategoryBtn" type="button">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<script>

    // Add New Category

    $(document).ready(function() {
        $('#createCategoryBtn').click(function(e) {
            e.preventDefault();

            let formData = $('#createCategoryForm').serialize();

            $.ajax({
                url: "{{ route('employee_categories.store') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#createGroupModal').modal('hide');
                    toastr.success(response.success);
                    location.reload();
                    // Optionally, refresh the categories list or table here
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Handle validation error
                        let errors = xhr.responseJSON.errors;
                        if (errors.emp_category) {
                            toastr.error(errors.emp_category[0]); // Show the first validation error
                        }
                    }
                }
            });
        });
    });

    // Edit Category

    $(document).on('click', '.btn-soft-primary[data-bs-toggle="modal"][data-bs-target="#editGroupModal"]', function(e) {
        e.preventDefault();

        // Retrieve data attributes from the button
        var categoryId = $(this).data('id');
        var categoryName = $(this).data('name');

        // Set the values in the modal form
        $('#editCategoryId').val(categoryId);
        $('#editFormGroupName').val(categoryName);

        // Show the modal
        $('#editGroupModal').modal('show');
    });

    // Update Category

    $('#editGroupModal').on('click', '.btn-primary-soft', function() {
        var categoryName = $('#editGroupModal #editFormGroupName').val();
        var id = $('#editGroupModal #editCategoryId').val();

        $.ajax({
            url: '{{ route('employee_categories.update', '') }}/' + id,
            method: 'PUT',
            data: {
                emp_category: categoryName,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success(response.success);
                location.reload(); // Reload page to reflect changes
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.log(xhr.responseText);
            }
        });
    });

    $(document).ready(function() {
        $('#empCatTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employee_categories.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'emp_category', name: 'emp_category' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            drawCallback: function(settings) {
                    feather.replace(); // Re-initialize Feather icons
            },
            order: [[1, 'asc']], // Sort by the companyname column by default
        });
    });

</script>
@endsection
