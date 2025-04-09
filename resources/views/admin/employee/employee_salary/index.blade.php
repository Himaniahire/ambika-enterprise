@extends('admin.layouts.layout')
@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Employee Attendance List
                            </h1>
                        </div>
                        {{-- <div class="col-12 col-xl-auto mb-3 d-flex">
                            <div class="col-6 col-md-6" style="margin-right: 10px;">
                                <label class="small mb-1" for="inputFirstName">Start Date</label>
                                <input class="form-control" id="start_date" type="date" name="start_date"
                                    value="" />
                            </div>
                            <div class="col-6 col-md-6" id="inputContainer">
                                <label class="small mb-1" for="inputFirstName">End Date</label>
                                <input class="form-control" type="date" name="end_date" id="end_date"
                                    value="" />
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Company Name</th>
                                <th>Attendance Date</th>
                                <th>Attendance Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Company Name</th>
                                <th>Attendance Date</th>
                                <th>Attendance Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($employeeAttendances as $employee)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $employee->getEmployee->first_name }} {{ $employee->getEmployee->father_name }} {{ $employee->getEmployee->last_name }}</td>
                                    <td>{{ $employee->getEmployee->emp_code }}</td>
                                    <td>{{ $employee->getCompany->companyname }}</td>
                                    <td>{{ \Carbon\Carbon::parse($employee->attendance_date)->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge
                                            @if($employee->status == 0) bg-danger @endif
                                            @if($employee->status == 1) bg-success @endif
                                            @if($employee->status == 2) bg-warning @endif
                                            @if($employee->status == 3) bg-primary @endif
                                        ">
                                            @if($employee->status == 0) Absent @endif
                                            @if($employee->status == 1) Present @endif
                                            @if($employee->status == 2) Half Day @endif
                                            @if($employee->status == 3) Holiday @endif
                                        </span>
                                        @if(in_array($employee->status, [1, 2, 3]))
                                            OT:{{ $employee->over_time }}
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>


@endsection

@section('footer-script')

<!--Import jQuery before export.js-->



<script type="text/javascript">




</script>





@endsection
