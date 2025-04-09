@extends('admin.layouts.layout')
@section('content')

<style>
    .error {
        color: red;
        font-size: 0.875em;
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
                            Edit User
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-primary" href="{{route('user.index')}}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to User List
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
                    <div class="card-header">User</div>
                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id ) }}" method="POST" id="registrationForm">
                            @csrf
                            @method('PUT')
                            @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error')}}
                        </div>
                        @endif
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="productname">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{$user->first_name}}">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <span class="error" id="first_name_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{$user->last_name}}">
                                    <span class="error" id="last_name_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="manufacturername">Username </label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="{{$user->username}}">
                                    <span class="error" id="username_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{$user->email}}">
                                    <span class="error" id="email_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Password In Text</label>
                                    <input type="text" name="" id="" class="form-control" placeholder="Password" value="{{$user->in_text}}" disabled>
                                    {{-- <span class="error" id="password_error"></span> --}}
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Password</label>
                                    <input type="text" name="password" id="password" class="form-control" placeholder="Password" value="" >
                                    {{-- <span class="error" id="password_error"></span> --}}
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Role</label>
                                    <select class="form-control" name="role_id" id="role_id">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{$role->id}}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ ucfirst($role->name)}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error" id="role_id_error"></span>
                                </div>

                                <div class="col-6 col-md-6">
                                    <label for="permission_id">Permission</label>
                                    <select class="form-control select2" name="permission_id[]" id="permission_id" multiple="multiple">
                                        <option value="">Select Permission</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}"
                                                @if($userPermissions->contains('id', $permission->id)) selected @endif>
                                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error" id="role_id_error"></span>
                                </div>







                            </div>
                            <button class="btn btn-primary" id="submitBtn" type="submit">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer-script')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // $(document).ready(function () {
    //     $('#registrationForm').submit(function (event) {
    //         event.preventDefault();
    //         var formData = $(this).serialize();
    //         $.ajax({
    //             type: 'POST',
    //             url: '{{ route("user.store") }}', // Change this to your route
    //             data: formData,
    //             success: function (data) {
    //                 // If validation passes, redirect or do whatever you need
    //                 window.location.replace("{{ route('user.index') }}"); // Change this to your redirect route
    //             },
    //             error: function (xhr, status, error) {
    //                 var errors = xhr.responseJSON.errors;
    //                 // Loop through each error and display them
    //                 $.each(errors, function (key, value) {
    //                     $('#' + key + '_error').text(value);
    //                 });
    //             }
    //         });
    //     });
    // });

    $(document).ready(function() {
    // Initialize Select2
    $('.select2').select2();

    // Listen for change in select2
    $('#permission_id').on('change', function() {
        var selectedPermissions = $(this).val(); // Get the selected permission IDs
        console.log('Selected Permissions: ', selectedPermissions);

        // Identify removed permissions by comparing with the previous state
        var removedPermissions = [];

        // Get the initial state of selected permissions if available
        var initialPermissions = $(this).data('initial-permissions') || [];

        // Find permissions that were removed (not in selected)
        removedPermissions = initialPermissions.filter(function(permission) {
            return !selectedPermissions.includes(permission);
        });

        console.log('Removed Permissions: ', removedPermissions);

        // If there are permissions to be removed, send the AJAX request
        if (removedPermissions.length > 0) {
            var user_id = $('input[name="user_id"]').val(); // Get user_id from the hidden input field
            var role_id = $('#role_id').val(); // Get the selected role_id from the select dropdown

            $.ajax({
                url: '{{ route('permissions.remove') }}', // Adjust URL if needed
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                    user_id: user_id,
                    role_id: role_id,
                    removed_permissions: removedPermissions
                },
                success: function(response) {
                    console.log('Success:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.log(xhr.responseText); // Check the full response in case of errors
                }
            });

        }

        // Update the initial permissions after the change for future comparisons
        $(this).data('initial-permissions', selectedPermissions);
    });

    // Initialize the initial selected permissions
    $('#permission_id').each(function() {
        var initialPermissions = $(this).val() || [];
        $(this).data('initial-permissions', initialPermissions);
    });
});



</script>
@endsection
