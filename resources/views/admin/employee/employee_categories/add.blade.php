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
                            Add Employee Post
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-primary" href="{{route('employee_posts.index')}}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Employee Post List
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
                    <div class="card-header">Employee Post Details</div>
                    <div class="card-body">
                        <form action="{{ route('employee_posts.store') }}" method="POST" id="empPostAdd">
                            @csrf
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="productname">Employee Post</label>
                                    <input id="productname" name="emp_post" type="text" class="form-control emp_post @error('emp_post') is-invalid @enderror" value="{{ old('companyname') }}" placeholder="Employee Post">
                                    @error('emp_post')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Add Employee Post</button>
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
    $(document).ready(function () {
        $('#empPostAdd').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.invalid-feedback').remove();

            // Validate company name
            if ($('.emp_post').val() === '') {
                isValid = false;
                $('.emp_post').addClass('is-invalid').after('<div class="invalid-feedback">Please select a Employee Post.</div>');
            } else {
                $('.emp_post').removeClass('is-invalid');
            }

            // Prevent form submission if not valid
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>

@endsection
