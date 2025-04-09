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
                                Company Transfer Employee Detail List
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
                    <table id="comTransTable" >
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($employees as $employee)
                                <tr>
                                    <form action="{{ route('employee_company_transfer.update', $employee->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td>
                                            <input type="hidden" name="id" value="{{ $employee->id }}">
                                            {{ $i++ }}
                                        </td>
                                        <td>
                                            <select style="width: 60%" class="form-control" name="company_id" id="company_id">
                                                @if ($employee->company_id)
                                                    <option value="{{ $employee->getCompany->id }}">{{ $employee->getCompany->companyname }}</option>
                                                @else
                                                    <option value="">Select Company</option>
                                                @endif
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->companyname }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ $employee->first_name }} {{ $employee->father_name }} {{ $employee->last_name }}</td>
                                        <td>{{ $employee->emp_code }}</td>
                                        <td>
                                            <button class="btn" type="submit" >
                                                <img src="{{ asset('admin_assets/index_icon/knowledge.png') }}" style="width: 30px;" alt="Update">
                                            </button>
                                        </td>
                                    </form>
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

<script>
$(document).ready(function() {
    $('#comTransTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true
    });
});

</script>

@endsection
