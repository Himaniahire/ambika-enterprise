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
                                Monthly Attendance Report
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
                        <div class="card-header">Monthly Attendance Report</div>
                        <div class="card-body">
                            <form action="{{route('export.attendance')}}" method="" id="report-form">
                                @csrf
                                <!-- Form Row -->
                                <input type="hidden" name="export_type" id="export_type" value="">
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
                                        <label class="small mb-1" for="monthDropdown">Month</label>
                                        <input type="month" class="form-control" name="month" id="monthDropdown">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" onclick="setExportType('excel')">Get Excel</button>
                                <button class="btn btn-primary" type="submit" onclick="setExportType('pdf')">Get PDF</button>
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
    $(document).ready(function() {
            var months = [
                { value: '01', name: 'January' },
                { value: '02', name: 'February' },
                { value: '03', name: 'March' },
                { value: '04', name: 'April' },
                { value: '05', name: 'May' },
                { value: '06', name: 'June' },
                { value: '07', name: 'July' },
                { value: '08', name: 'August' },
                { value: '09', name: 'September' },
                { value: '10', name: 'October' },
                { value: '11', name: 'November' },
                { value: '12', name: 'December' }
            ];

            $.each(months, function(index, month) {
                $('#monthDropdown').append($('<option>', {
                    value: month.value,
                    text: month.name
                }));
            });

            var startYear = 2023;
            var endYear = new Date().getFullYear();
            for (var year = startYear; year <= endYear; year++) {
                $('#yearDropdown').append($('<option>', {
                    value: year,
                    text: year
                }));
            }
        });

        function setExportType(type) {
        document.getElementById('export_type').value = type;
    }
</script>

@endsection
