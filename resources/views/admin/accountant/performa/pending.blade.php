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
                                Performas List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @error('performa_date')
                                    <li class="text-danger">{{ $message }}</li>
                                @enderror
                                @error('tax')
                                    <li class="text-danger">{{ $message }}</li>
                                @enderror
                            </ul>
                        </div>
                    @endif
                    <table id="perPenTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Performa Date</th>
                                <th>Performa No</th>
                                <th>Summary No</th>
                                <th>Invoice No</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Performa Date</th>
                                <th>Performa No</th>
                                <th>Summary No</th>
                                <th>Invoice No</th>
                                <th>Total</th>
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
    $('#perPenTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('performa.pending') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'company_name', name: 'company_name' },
            { data: 'performa_date', name: 'performa_date' },
            { data: 'performa_no', name: 'performa_no' },
            { data: 'summary_no', name: 'summary_no' },
            { data: 'invoice_no', name: 'invoice_no' },
            { data: 'total', name: 'total' },
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
