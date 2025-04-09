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
                            Add Employee Holiday
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-primary" href="{{route('employee_holidays.index')}}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Employee Holiday List
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
                    <div class="card-header">Employee Holiday Details</div>
                    <div class="card-body">
                        <form action="{{ route('employee_holidays.store') }}" method="POST" id="empHolidayAdd">
                            @csrf
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group -->
                                <div class="col-6 col-md-6">
                                    <label for="productname">Holiday Date <span class="text-danger">*</span></label>
                                    <input id="productname" name="holiday_date" type="date" class="form-control holiday_date @error('holiday_date') is-invalid @enderror" value="{{ old('companyname') }}" placeholder="Employee Post">
                                    @error('holiday_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="productname">Holiday Day <span class="text-danger">*</span></label>
                                    <input id="productname" name="holiday" type="text" class="form-control holiday @error('holiday') is-invalid @enderror" value="{{ old('companyname') }}" placeholder="Employee Post">
                                    @error('holiday')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Add Employee Holiday</button>
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
        $('#empHolidayAdd').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.invalid-feedback').remove();

            // Validate company name
            if ($('.holiday_date').val() === '') {
                isValid = false;
                $('.holiday_date').addClass('is-invalid').after('<div class="invalid-feedback">Please enter a Holiday Date.</div>');
            } else {
                $('.holiday_date').removeClass('is-invalid');
            }

            if ($('.holiday').val() === '') {
                isValid = false;
                $('.holiday').addClass('is-invalid').after('<div class="invalid-feedback">Please enter a Holiday Day.</div>');
            } else {
                $('.holiday').removeClass('is-invalid');
            }

            // Prevent form submission if not valid
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>

@endsection
