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
                            Add User
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
                        <form action="{{ route('user.store') }}" method="POST" id="registrationForm">
                            @csrf
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
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                                    <span class="error" id="first_name_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                                    <span class="error" id="last_name_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="manufacturername">Username </label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                                    <span class="error" id="username_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    <span class="error" id="email_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    <span class="error" id="password_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                                    <span class="error" id="confirm_password_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Role</label>
                                    <select class="form-control" name="role_id" id="role_id">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{$role->id}}">{{ ucfirst($role->name)}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error" id="role_id_error"></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="permission_id">Permission</label>
                                    <select class="form-control select2" name="permission_id[]" id="permission_id" multiple="multiple">
                                        <option value="">Select Permission</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error" id="role_id_error"></span>
                                </div>
                            </div>
                            <button class="btn btn-primary" id="submitBtn" type="submit">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Use a stable jQuery version -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#registrationForm').submit(function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("user.store") }}', // Change this to your route
                data: formData,
                success: function (data) {
                    // If validation passes, redirect or do whatever you need
                    window.location.replace("{{ route('user.index') }}"); // Change this to your redirect route
                },
                error: function (xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    // Loop through each error and display them
                    $.each(errors, function (key, value) {
                        $('#' + key + '_error').text(value);
                    });
                }
            });
        });
    });

    // $(document).ready(function() {
    //     $('#permission_id').select2({
    //         placeholder: "Select Permission",
    //         allowClear: true,
    //         width: '100%'
    //     });
    // });

    $(document).ready(function() {
    $('#permission_id').select2();
});


</script>
@endsection
